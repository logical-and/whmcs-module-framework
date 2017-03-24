<?php

namespace WHMCS\Module\Framework\Events;

use ErrorException;
use WHMCS\Module\Framework\AbstractModule;
use WHMCS\Module\Framework\Helper;

abstract class AbstractListener
{
    protected $name;

    protected $priority = 0;

    protected $registered = false;

    protected static $enabled = true;

    public static function build()
    {
        return new static();
    }

    protected function preExecute()
    {
        if (!static::$enabled) {
            return false;
        }

        return true;
    }

    abstract protected function execute();

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
*@param string $name
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

    public static function enable()
    {
        static::$enabled = true;
    }

    public static function disable()
    {
        static::$enabled = false;
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
        return $_SESSION['uid'];
    }
}
