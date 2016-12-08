<?php

namespace WHMCS\Module\Framework;

use ErrorException;
use Illuminate\Database\Capsule\Manager;

class Module
{

    /** @var Module[] */
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
     * @return Module|static
     */
    public static function registerModuleByFile($file, array $config)
    {
        // Prevent double registration
        foreach (self::$instances as $instance)
        {
            if ($file == $instance->getFile()) {
                return $instance;
            }
        }

        return new static($file, $config);
    }

    public static function getInstanceById($id)
    {
        if (empty(self::$instances[ $id ])) {
            throw new ErrorException("Module with id \"$id\" wasn't loaded/initialized");
        }

        return self::$instances[ $id ];
    }

    public function __construct($file, array $config)
    {
//        ini_set('display_errors', 1);
//        error_reporting(E_ALL);
        if (!is_file($file)) {
            throw new ErrorException("Module register: that is not a file \"$file\"");
        }

        $id = pathinfo($file, PATHINFO_FILENAME);

        // prevent double registration
        if (!empty(self::$instances[ '$id' ][ $id ])) {
            throw new ErrorException("Module \"$id\" is already registered");
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
        self::$instances[ $id ] = $this;

        // Now, register it
        if (!function_exists($id . '_config')) {
            eval(sprintf('function %s_config() { return %s; }', $id, var_export($config, true)));
        }

        return $this;
    }

    public function getId()
    {
        if (!$this->id) {
            $this->id = '';
        }

        return $this->id;
    }

    public function getConfig()
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
        }

        return $this->config;
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function getFile()
    {
        return $this->file;
    }
}