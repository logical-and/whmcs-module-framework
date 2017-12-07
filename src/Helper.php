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

    protected static $connections = [];

    public static function api($method, array $data = [], $workarounds = true)
    {
        if ($workarounds) {
            $response = WhmcsWorkarounds::apiCall($method, $data);

            if (!is_null($response)) {
                return $response;
            }
        }

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
            $data = self::connAssoc()->selectOne('SELECT username FROM tbladmins WHERE disabled = 0 LIMIT 1');
            if (!empty($data['username'])) {
                $adminUser = $data['username'];
            }
            else {
                throw new ErrorException('Admin user couldnt be retrieved from database');
            }
        }

        return $adminUser;
    }

    public static function conn($fetchMode = \PDO::FETCH_ASSOC)
    {
        if (empty(self::$connections[$fetchMode])) {
            /** @noinspection PhpUndefinedClassInspection */
            $conn = self::$connections[$fetchMode] = ConnectionClone::constructClone(Manager::connection());
            /** @noinspection PhpUndefinedMethodInspection */
            $conn->setFetchMode($fetchMode);
        }

        return self::$connections[$fetchMode];
    }

    public static function connAssoc()
    {
        return static::conn(\PDO::FETCH_ASSOC);
    }

    public static function connObj()
    {
        return static::conn(\PDO::FETCH_OBJ);
    }

    public static function db()
    {
        return static::connAssoc();
    }

    /**
     * @deprecated No need to use this method anymore since connection is cloned
     */
    public static function restoreDb()
    {

    }

    /**
     * Get WHMCS version
     * @return float
     */
    public static function getWHMCSVersion()
    {
        global $CONFIG;

        // Convert to true float
        $version = $CONFIG['Version'];
        $version = explode('.', $version);
        $version = rtrim(($version[0] . '.' . join('', array_slice($version, 1))), '.');

        return (float) $version;
    }

    public static function getConfigValue($key, $default = null)
    {
        if (self::getWHMCSVersion() > 7) {
            $result = Helper::api('GetConfigurationValue', ['setting' => $key], 'result=success');

            // Request is successful, handle it
            if (!empty($result['result']) and 'success' == $result['result']) {
                // Data is found, return it
                if (isset($result['value'])) {
                    return $result['value'];
                }

                // Data not found return the default value
                return $default;
            }
        }

        $result = Helper::connAssoc()->selectOne("SELECT value FROM tblconfiguration WHERE setting = ?", [$key]);
        if (isset($result['value'])) {
            return $result['value'];
        }

        return $default;
    }

    public static function getRootDir()
    {
        /** @noinspection PhpUndefinedConstantInspection */
        return rtrim(ROOTDIR, '/');
    }

    public static function renderTemplate($file, array $vars = [])
    {
        global $templates_compiledir;

        /** @noinspection PhpUndefinedClassInspection */
        $smarty = new \Smarty();
        $smarty->compile_dir = $templates_compiledir;

        foreach ($vars as $key => $value) {
            $smarty->assign($key, $value);
        }

        // Render template
        $rendered = $smarty->fetch($file);

        return $rendered;
    }
}
