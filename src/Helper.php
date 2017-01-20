<?php

namespace WHMCS\Module\Framework;

use Axelarge\ArrayTools\Arr;
use ErrorException;
use /** @noinspection PhpUndefinedClassInspection */
    /** @noinspection PhpUndefinedNamespaceInspection */
    Illuminate\Database\Capsule\Manager;

class Helper
{
    protected static $defaultFetchMode;

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

    public static function apiResponse($method, array $data, $keyToCheck,
        $message = 'Wrong response - %s (request - "%s", args - %s)',
        $exceptionClass = ErrorException::class)
    {
        $response = self::api($method, $data);

        // Key=value
        if (false !== strpos($keyToCheck, '=')) {
            list($keyToCheck, $valueToCheck) = explode('=', $keyToCheck);
        }

        $foundValue = Arr::getNested($response, $keyToCheck);

        if (is_null($foundValue) or (isset($valueToCheck) and $valueToCheck != $foundValue)) {
            throw new $exceptionClass(sprintf($message, json_encode($response), $method, json_encode($data)));
        }

        return $response;
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
        $conn = Manager::connection();

        if (!empty(self::$defaultFetchMode)) {
            $conn->setFetchMode(self::$defaultFetchMode);
        }
        else {
            self::$defaultFetchMode = $conn->getFetchMode();
        }

        return $conn;
    }

    public static function conn($fetchMode = \PDO::FETCH_ASSOC)
    {
        $conn = self::db();
        $conn->setFetchMode($fetchMode);

        return $conn;
    }

    public static function restoreDb()
    {
        self::db();
    }
}
