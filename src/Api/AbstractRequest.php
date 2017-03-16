<?php

namespace WHMCS\Module\Blazing\DashboardProxy\Api;

use WHMCS\Module\Framework\Helper;

abstract class AbstractRequest
{
    protected function response($method, array $args = [], $resultPath = '')
    {
        $data = Helper::api($method, $args);

        return new ArrayResult($data, $resultPath, $method, $args);
    }
}
