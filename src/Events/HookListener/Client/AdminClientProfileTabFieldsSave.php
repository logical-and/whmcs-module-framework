<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminClientProfileTabFieldsSave extends AbstractHookListener
{
    const KEY = 'AdminClientProfileTabFieldsSave';

    protected $code = self::KEY;
}