<?php

namespace WHMCS\Module\Framework\Events;

use ErrorException;
use Smarty;
use WHMCS\Module\Framework\AbstractModule;
use WHMCS\Module\Framework\Helper;

abstract class AbstractListener
{
    protected $name;

    protected $priority = 0;

    protected $registered = false;

    protected $enabled = true;

    public static function build()
    {
        return new static();
    }

    protected function preExecute()
    {
        if (!$this->enabled) {
            static::disable();
        }

        if (!static::isEnabled()) {
            return false;
        }

        return true;
    }

    /**
     * @param array
     * @return mixed
     */
    abstract protected function execute();

    protected function onExecuteException(\Exception $e)
    {

    }

    abstract public function register();

    /**
     * @return AbstractModule
     */
    abstract public function getModule();

    /**
     * Get event
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set event
     *
     * @param string $name
     * @return $this
     * @throws ErrorException
     */
    public function setName($name)
    {
        if (empty(trim((string) $name))) {
            throw new ErrorException('Hook name cannot be empty!');
        }
        $this->name = $name;

        return $this;
    }

    /**
     * Get priority
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set priority
     *
     * @param int $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    public function callHandler(array $args)
    {
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        return $this->execute($args);
    }

    // --- Global settings

    /** @noinspection PhpInconsistentReturnPointsInspection */
    protected static function sharedVariable($key, $value = null)
    {
        static $vars = [];
        if (!is_null($value)) {
            $vars[$key] = $value;
        }
        else {
            return isset($vars[$key]) ? $vars[$key] : null;
        }
    }

    public static function enable()
    {
        static::sharedVariable('disabled', false);
    }

    public static function disable()
    {
        static::sharedVariable('disabled', true);
    }

    public static function isEnabled()
    {
        return !static::sharedVariable('disabled');
    }

    // --- Shortcuts

    public function db()
    {
        return Helper::conn();
    }

    public function api($method, array $data)
    {
        return Helper::api($method, $data);
    }

    public function getUserId()
    {
        return !empty($_SESSION['uid']) ? $_SESSION['uid'] : false;
    }

    // --- Helpers

    protected function view($template, array $vars = [], $dir = null)
    {
        global $templates_compiledir;

        $smarty = new Smarty();
        $smarty->compile_dir = $templates_compiledir;

        foreach ($vars as $key => $value) {
            $smarty->assign($key, $value);
        }

        // Render template
        $templateDir = rtrim($dir ? $dir : $this->getTemplatesDir(), '/');
        $rendered = $smarty->fetch("$templateDir/$template");

        Helper::restoreDb();

        return $rendered;
    }

    protected function getTemplatesDir()
    {
        return $this->getModule()->getDirectory() . "/templates";
    }

    protected function getRelativeTemplatesDir()
    {
        return str_replace('\\', '/', str_replace(ROOTDIR, '', $this->getTemplatesDir()));
    }
}