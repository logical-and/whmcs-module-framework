<?php

namespace WHMCS\Module\Framework;

use ErrorException;
use /** @noinspection PhpUndefinedClassInspection */
    /** @noinspection PhpUndefinedNamespaceInspection */
    Illuminate\Database\Capsule\Manager;

class Helper
{
    public static function api($method, array $data = [])
    {
        $preparedMethod = strtolower($method);
        $preparedData = [];

        foreach ($data as $key => $value) {
            $preparedData[strtolower($key)] = $value;
        }

        /** @noinspection PhpUndefinedFunctionInspection */
        $data = localApi($preparedMethod, $preparedData, self::getAdminUser());

        return $data;
    }

    public static function dumpAsJson($var)
    {
        $string = json_encode($var, JSON_PRETTY_PRINT);

        if (php_sapi_name() == "cli") {
            echo $string;
        }
        else {
            echo "<pre>$string</pre>";
        }
    }

    public static function getAdminUser()
    {
        static $adminUser;

        if (!$adminUser) {
            $data = self::db()->selectOne('SELECT username FROM tbladmins WHERE disabled = 0 LIMIT 1');
            if (!empty($data->username)) {
                $adminUser = $data->username;
            }
            else {
                throw new ErrorException('Admin user couldnt be retrieved from database');
            }
        }

        return $adminUser;
    }

    public static function db()
    {
        /** @noinspection PhpUndefinedClassInspection */
        return Manager::connection();
    }
}
