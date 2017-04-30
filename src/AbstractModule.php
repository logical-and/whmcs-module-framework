<?php

namespace WHMCS\Module\Framework;

use Axelarge\ArrayTools\Arr;
use ErrorException;
use Illuminate\Database\Capsule\Manager;
use WHMCS\Module\Framework\Events\AbstractModuleListener;

abstract class AbstractModule
{
    const TYPE = 'abstract';

    /** @var AbstractModule[][] */
    protected static $instances = [];

    /** @var string */
    protected $id;

    /** @var array */
    protected $config = [];

    /** @var array */
    protected $originalConfig;

    /** @var string */
    protected $directory;

    /** @var string */
    protected $file;

    /**
     * @param string $file __FILE__
     * @param array $config [ 'name' => 'Plugin name', 'description' => '', 'version' => '1.0', 'author' => '' ]
     * @return Addon|static
     */
    public static function registerModuleByFile($file, array $config)
    {
        // Prevent double registration
        $instance = static::getInstanceByFile($file, false);

        return $instance ? $instance : new static($file, $config);
    }

    public static function getInstanceById($id, $throw = true)
    {
        if (empty(self::$instances[static::TYPE][ $id ])) {
            if ($throw) {
                throw new ErrorException("Module with id \"$id\" and type " . static::TYPE . " wasn't loaded/initialized");
            }
            else {
                return false;
            }
        }

        return self::$instances[static::TYPE][ $id ];
    }

    public static function getInstanceByFile($file, $throw = true)
    {
        foreach (self::$instances as $type => $instances)
        {
            foreach ($instances as $instance) {
                if (str_replace('\\', '/', $file) == str_replace('\\', '/', $instance->getFile())) {
                    return $instance;
                }
            }
        }

        if ($throw) {
            throw new ErrorException("Module file \"$file\" wasn't loaded/initialized");
        }
        else {
            return false;
        }
    }

    public function __construct($file, array $config)
    {
        if (!is_file($file)) {
            throw new ErrorException("Module register: that is not a file \"$file\"");
        }

        $id = pathinfo($file, PATHINFO_FILENAME);

        // prevent double registration
        if (static::getInstanceById($id, false)) {
            throw new ErrorException("Module with id \"$id\" and type " . static::TYPE . " already loaded/initialized");
        }

        // test is name valid
        $regex = '^[a-zA-Z0-9_]+$';
        if (!preg_match("~$regex~", $id)) {
            throw new ErrorException("Module name \"$id\" is invalid (should only contain $regex");
        }

        // addons/module-name/module-name.php
        $directory = realpath(dirname($file));
        if ($id != pathinfo($directory, PATHINFO_FILENAME)) {
            throw new ErrorException("Module register: file \"$file\" directory name must be the same as file name, " .
                'current name "' . pathinfo(realpath(dirname(__FILE__)), PATHINFO_FILENAME) . '"' .
                "(WHMCS requirements");
        }

        $this->id               = $id;
        $this->originalConfig   = $config;
        $this->directory        = $directory;
        $this->file             = $file;
        self::$instances[static::TYPE][ $id ] = $this;

        // Now, register it
        $this->register();

        return $this;
    }

    public function registerModuleListeners($classes = [])
    {
        foreach ($classes as $class) {
            if (is_string($class)) {
                /** @var AbstractModuleListener $instance */
                $instance = new $class();
            }
            else {
                $instance = $class;
            }

            $abstractParent = AbstractModuleListener::class;
            if (!$instance instanceof $abstractParent) {
                throw new ErrorException(sprintf('Class "%s" should be inherited from "%s" class',
                    $class, AbstractModuleListener::class));
            }

            $instance->setModule($this)->register();
        }

        return $this;
    }

    /**
     * Called only once
     */
    abstract protected function register();

    protected function registerConfigFunction($name, array $config)
    {
        if (!function_exists($name)) {
            eval(sprintf('function %s() { return %s; }', $name, var_export($config, true)));
        }

        return $this;
    }

    // --- Accessors

    public function getId()
    {
        if (!$this->id) {
            $this->id = '';
        }

        return $this->id;
    }

    public function getConfig($key = null, $default = null)
    {
        if (!$this->config) {
            // Set original config values
            $config[ 'original' ] = $this->originalConfig;
            if (!empty($config[ 'original' ][ 'fields' ])) {
                foreach ($config[ 'original' ][ 'fields' ] as $field => $data) {
                    if (isset($data[ 'Default' ])) {
                        $config[ $field ] = $data[ 'Default' ];
                    }
                }
            }

            $moduleName = $this->getId();
            foreach (Manager::connection()->select("SELECT * FROM tbladdonmodules WHERE module = '$moduleName'") as $row) {
                $row                         = json_decode(json_encode($row), true);
                $config[ $row[ 'setting' ] ] = html_entity_decode($row[ 'value' ]);
            }

            $this->config = $config;
        }

        return !$key ? $this->config : Arr::getNested($this->config, $key, $default);
    }

    public function getOriginalConfig($key = null, $default = null)
    {
        return !$key ? $this->originalConfig : Arr::getNested($this->originalConfig, $key, $default);
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function getRelativeDirectory()
    {
        return str_replace('\\', '/', str_replace(ROOTDIR, '', $this->getDirectory()));
    }

    public function getFile()
    {
        return $this->file;
    }
}