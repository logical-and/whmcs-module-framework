<?php

namespace WHMCS\Module\Framework;

use Axelarge\ArrayTools\Arr;

class Addon extends AbstractModule
{
    const TYPE = 'addon';
    const TYPE_DIRECTORY = 'modules/addons';

    /**
     * Called only once
     */
    protected function register()
    {
        $this->registerConfigFunction($this->getId() . '_config', $this->getOriginalConfig());
    }

    public function getConfig($key = null, $default = null)
    {
        if (!$this->config) {
            // Set original config values
            $config[ 'original' ] = $this->getOriginalConfig();
            if (!empty($config[ 'original' ][ 'fields' ])) {
                foreach ($config[ 'original' ][ 'fields' ] as $field => $data) {
                    if (isset($data[ 'Default' ])) {
                        $config[ $field ] = $data[ 'Default' ];
                    }
                }
            }

            $moduleName = $this->getId();
            foreach (Helper::conn()->select("SELECT * FROM tbladdonmodules WHERE module = '$moduleName'") as $row) {
                $row                         = json_decode(json_encode($row), true);
                $config[ $row[ 'setting' ] ] = html_entity_decode($row[ 'value' ]);
            }

            $this->config = $config;
        }

        return !$key ? $this->config : Arr::getNested($this->config, $key, $default);
    }

    public function isEnabled()
    {
        return static::isModuleEnabled($this->getId());
    }

    public static function isModuleEnabled($id)
    {
        return self::getStaticCachedResult(static::TYPE . $id, function() use ($id) {
            $result = !!Helper::conn()
                ->selectOne("SELECT count(*) as enabled FROM tbladdonmodules WHERE module = ?", [$id])['enabled'];
            Helper::restoreDb();

            return $result;
        });
    }
}