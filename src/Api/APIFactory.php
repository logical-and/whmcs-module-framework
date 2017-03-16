<?php

namespace WHMCS\Module\Blazing\DashboardProxy\Api;

use RuntimeException;

class APIFactory
{

    protected static $classes = [
        'orders'  => Orders::class,
        'billing' => Billing::class,
        'system' => System::class
    ];
    protected static $classesCustom = [];
    protected static $instances = [];

    /**
     * @return Orders
     */
    public static function orders()
    {
        return self::getOrLoad('orders');
    }

    /**
     * @return Billing
     */
    public static function billing()
    {
        return self::getOrLoad('billing');
    }

    /**
     * @return System
     */
    public static function system()
    {
        return self::getOrLoad('system');
    }

    protected static function getOrLoad($requestor)
    {

        if (isset(self::$classesCustom[ $requestor ])) {
            $class = self::$classesCustom[ $requestor ];
        }
        elseif (isset(self::$classes[ $requestor ])) {
            $class = self::$classes[ $requestor ];
        }
        else {
            throw new RuntimeException("Requestor \"$requestor\" has not been found");
        }

        if (empty(self::$instances[ $class ])) {
            if (!is_subclass_of($class, AbstractRequest::class)) {
                throw new RuntimeException(sprintf('Class must be an inheritor of %s, %s passed',
                    AbstractRequest::class, $class));
            }
            self::$instances[ $class ] = new $class();
        }

        return self::$instances[ $class ];
    }
}
