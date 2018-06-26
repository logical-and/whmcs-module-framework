<?php

namespace WHMCS\Module\Framework;

use Axelarge\ArrayTools\Arr;
use Gears\Arrays;

class ModuleStorage
{

    /**
     * @var AbstractModule
     */
    protected $module;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Whether data loaded or not
     *
     * @var bool
     */
    protected $dataLoaded = false;

    /**
     * Keys with updated data
     *
     * @var array
     */
    protected $dataUpdate = [];

    /**
     * Keys with removed data
     *
     * @var array
     */
    protected $dataRemove = [];

    public function __construct(AbstractModule $module)
    {
        $this->module = $module;
    }

    /**
     * Get data by key (can be path divided by dots - `.`)
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $this->loadData();

        return Arr::getNested($this->data, $key, $default);
    }

    /**
     * Set data to storage
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        Arrays::set($this->data, $key, $value);
        $this->dataUpdate[] = $this->splitKeyPath($key)[0];

        $this->persistData();

        return $this;
    }

    /**
     * Is there data in storage
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        $this->loadData();

        return Arrays::has($this->data, $key);
    }

    /**
     * Remove data from storage
     * @param $key
     * @return $this
     */
    public function remove($key)
    {
        Arrays::forget($this->data, $key);
        $this->dataRemove[] = $this->splitKeyPath($key)[0];

        $this->persistData();

        return $this;
    }

    // --- Internal

    protected function loadData()
    {
        // Nothing to process
        if ($this->dataLoaded) {
            return $this;
        }

        $data = Helper::connAssoc()->select("SELECT setting, value FROM tbladdonmodules WHERE module = ?",
            [$this->getStorageKey()]);

        foreach ($data as $row) {
            $key = $row[ 'setting' ];
            $value = $row[ 'value' ];

            try {
                $value = @json_decode($value);
            } catch (\Exception $e) {
                continue;
            }

            $this->data[ $key ] = $value;
        }

        return $this;
    }

    protected function persistData()
    {
        // Nothing to update
        if (!$this->dataUpdate) {
            return $this;
        }

        // Skip any duplicates
        $this->dataUpdate = array_unique($this->dataUpdate);
        $this->dataRemove = array_unique($this->dataRemove);

        $storageKey = $this->getStorageKey();

        foreach ($this->dataUpdate as $mainKey) {
            if (isset($this->data[$mainKey])) {
                $data = $this->data[$mainKey];
                $row = Helper::connAssoc()->selectOne("SELECT id FROM tbladdonmodules WHERE module = ? AND setting = ?",
                    [$storageKey, $mainKey]);
                // Determine method
                if (!empty($row[ 'id' ])) {
                    // Insert
                    Helper::connAssoc()->update("UPDATE tbladdonmodules SET value = ? WHERE id = ?",
                        [json_encode($data), $row[ 'id' ]]);
                } else {
                    // Update
                    Helper::connAssoc()->insert("INSERT INTO tbladdonmodules (module, setting, value) VALUES (?, ?, ?)",
                        [$storageKey, $mainKey, json_encode($data)]);
                }
                unset($this->data[$mainKey]);
            }
        }
        $this->dataUpdate = [];

        foreach ($this->dataRemove as $mainKey) {
            if (isset($this->data[$mainKey])) {
                Helper::connAssoc()->delete(
                    "DELETE FROM tbladdonmodules WHERE module = ? AND setting = ?", [$storageKey, $mainKey]);

                unset($this->data[$mainKey]);
            }
        }
        $this->dataRemove = [];

        return $this;
    }

    // --- Helpers

    /**
     * Get scope for db storage
     *
     * @return string
     */
    protected function getStorageKey()
    {
        $class = get_class($this->module);
        $type = $class::TYPE;
        $name = $this->module->getId();

        return "STORAGE:$type:$name";
    }

    /**
     * Get ["main", "sub.path"] from "main.sub.path" string
     * @param $key
     * @return array
     */
    protected function splitKeyPath($key)
    {
        // It's already main key with subpath items
        if (false === strpos($key, '.')) {
            return [$key, null];
        }

        $key = explode('.', $key);

        return [$key[ 0 ], join('.', array_slice($key, 1))];
    }
}
