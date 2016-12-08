<?php

namespace WHMCS\Module\Framework;

abstract class AbstractSingletone
{

    protected static $instances = [];

    public static function getInstance()
    {
        $class = get_called_class();

        if (empty(self::$instances[ $class ])) {
            self::$instances[ $class ] = new static();
        }

        return self::$instances[ $class ];
    }

    protected function __construct() { }
}
