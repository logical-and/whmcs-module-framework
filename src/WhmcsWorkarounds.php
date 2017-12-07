<?php

namespace WHMCS\Module\Framework;

use Axelarge\ArrayTools\Arr;

class WhmcsWorkarounds
{
    public static function apiCall($method, array $args)
    {
        if (7.22 == Helper::getWHMCSVersion() and strtolower('GetClientsDetails') == strtolower($method)) {
            $args = self::arrayLowercaseKeys($args);
            $where = 'WHERE ';
            $whereData = [];

            if (!empty($args['clientid'])) {
                $where .= 'id = ?';
                $whereData[] = $args['clientid'];
            }
            elseif (!empty($args['email'])) {
                $where .= 'email = ?';
                $whereData[] = $args['email'];
            }
            else {
                return ["result" => "error", "message" => "Client Not Found"];
            }

            $data = Helper::connAssoc()->selectOne("SELECT id FROM tblclients $where LIMIT 1", $whereData);
            if (!$data) {
                return ["result" => "error", "message" => "Client Not Found"];
            }

            /** @noinspection PhpUndefinedFunctionInspection */
            if (!function_exists("getClientsDetails")) {
                /** @noinspection PhpUndefinedConstantInspection */
                /** @noinspection PhpIncludeInspection */
                require Helper::getRootDir() . "/includes/clientfunctions.php";
            }

            /** @noinspection PhpUndefinedFunctionInspection */
            return Arr::except(getClientsDetails($data['id']), ['model']);
        }

        return null;
    }

    protected static function arrayLowercaseKeys(array $data)
    {
        $preparedData = [];

        foreach ($data as $key => $value) {
            $preparedData[strtolower($key)] = $value;
        }

        return $preparedData;
    }
}
