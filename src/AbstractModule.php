<?php

namespace WHMCS\Module\Framework;

use Axelarge\ArrayTools\Arr;
use ErrorException;
use SymlinkDetective;
use WHMCS\Module\Framework\ConfigBuilder\AbstractConfigBuilder;
use WHMCS\Module\Framework\Events\AbstractModuleListener;

abstract class AbstractModule
{
    const TYPE = 'abstract';
    const TYPE_DIRECTORY = 'modules/abstract';

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

    /** @var array */
    protected $cache = [];
    protected static $staticCache = [];

    /** @var ModuleStorage */
    protected $storage;

    /**
     * @param string $file __FILE__
     * @param array|AbstractConfigBuilder $config [ 'name' => 'Plugin name', 'description' => '', 'version' => '1.0', 'author' => '' ]
     * @return Addon|static
     */
    public static function registerModuleByFile($file, $config)
    {
        // Prevent double registration
        $instance = static::getInstanceByFile($file, false);

        return $instance ? $instance : new static($file, $config);
    }

    public static function getInstanceById($id, $throw = true, $load = true)
    {
        if (empty(self::$instances[static::TYPE][ $id ])) {
            if ($load) {
                $path = Helper::getRootDir() . '/' . static::TYPE_DIRECTORY . "/$id/$id.php";
                if (is_file($path)) {
                    require_once $path;
                    return self::getInstanceById($id, $throw, false);
                }
            }

            if ($throw) {
                throw new ErrorException("Module with id \"$id\" and type " . static::TYPE . " has not been loaded/initialized");
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

    public static function isModuleEnabled($id)
    {
        $module = static::getInstanceById($id, false, false);

        return $module and $module->isEnabled();
    }

    /**
     * AbstractModule constructor.
     *
     * @param string $file Module file
     * @param array|AbstractConfigBuilder $config
     * @throws ErrorException
     */
    public function __construct($file, $config)
    {
        if (!is_file($file)) {
            throw new ErrorException("Module register: that is not a file \"$file\"");
        }

        $id = pathinfo($file, PATHINFO_FILENAME);

        // prevent double registration
        if (static::getInstanceById($id, false, false)) {
            throw new ErrorException("Module with id \"$id\" and type " . static::TYPE . " already loaded/initialized");
        }

        // test is name valid
        $regex = '^[a-zA-Z0-9_]+$';
        if (!preg_match("~$regex~", $id)) {
            throw new ErrorException("Module name \"$id\" is invalid (should only contain $regex");
        }

        // addons/module-name/module-name.php
        $directory = SymlinkDetective::detectPath(dirname($file));
        if ($id != pathinfo($directory, PATHINFO_FILENAME)) {
            throw new ErrorException("Module register: file \"$file\" directory name must be the same as file name, " .
                'current name "' . pathinfo(realpath(dirname(__FILE__)), PATHINFO_FILENAME) . '"' .
                "(WHMCS requirements");
        }

        $this->id               = $id;
        $this->originalConfig   = $config instanceof AbstractConfigBuilder ? $config->build() : (array) $config;
        $this->directory        = $directory;
        $this->file             = $file;
        self::$instances[static::TYPE][ $id ] = $this;

        $this->storage = new ModuleStorage($this);

        // Now, register it
        $this->register();

        return $this;
    }

    public function registerModuleListeners($classes = [])
    {
        foreach ($classes as $class) {
            /** @var AbstractModuleListener $class */
            /** @var AbstractModuleListener $instance */
            $instance = is_string($class) ? $class::getInstance() : $class;

            $abstractParent = AbstractModuleListener::class;
            if (!$instance instanceof $abstractParent) {
                throw new ErrorException(sprintf('Class "%s" should be inherited from "%s" class',
                    $class, AbstractModuleListener::class));
            }

            $instance->setModule($this);
            if (false !== $instance->preRegister()) {
                $instance->register();
            }
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
        return $this->getOriginalConfig($key, $default);
    }

    public function getOriginalConfig($key = null, $default = null)
    {
        return !$key ? $this->originalConfig : Arr::getNested($this->originalConfig, $key, $default);
    }

    public function isEnabled()
    {
        return true;
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function getRelativeDirectory()
    {
        return str_replace(
            SymlinkDetective::canonicalizePath(Helper::getRootDir()),
            '',
            SymlinkDetective::canonicalizePath($this->getDirectory())
        );
    }

    public function getPathUrl($path, array $args = [])
    {
        $systemUrl = Helper::getConfigValue('SystemURL');

        return rtrim($systemUrl, '/') .
            $this->getRelativeDirectory() .
            '/' . ltrim($path, '/') . (!$args ? '' : ('?' . http_build_query($args)));
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getTemplatesDir()
    {
        return $this->getDirectory() . "/templates";
    }

    public function getRelativeTemplatesDir()
    {
        return str_replace('\\', '/', str_replace(Helper::getRootDir(), '', $this->getTemplatesDir()));
    }

    // --- Helpers

    protected function getCachedResult($key, callable $callback)
    {
        $cacheId = md5(json_encode($key));

        // Use cache if possible
        if (isset($this->cache[ $cacheId ])) {
            return $this->cache[ $cacheId ];
        }

        return $this->cache[ $cacheId ] = $callback();
    }

    protected static function getStaticCachedResult($key, callable $callback)
    {
        $cacheId = md5(json_encode($key));

        // Use cache if possible
        if (isset(self::$staticCache[ $cacheId ])) {
            return self::$staticCache[ $cacheId ];
        }

        return self::$staticCache[ $cacheId ] = $callback();
    }

    public function view($template, array $vars = [], $dir = null)
    {
        $templateDir = rtrim($dir ? $dir : $this->getTemplatesDir(), '/');

        return Helper::renderTemplate("$templateDir/$template", $vars);
    }

    /**
     * Get module storage instance (key value, supports dot.paths)
     *
     * @return ModuleStorage
     */
    public function getStorage()
    {
        return $this->storage;
    }
}