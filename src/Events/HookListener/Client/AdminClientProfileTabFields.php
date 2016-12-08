<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminClientProfileTabFields extends AbstractHookListener
{
    const KEY = 'AdminClientProfileTabFields';

    protected $code = self::KEY;
}