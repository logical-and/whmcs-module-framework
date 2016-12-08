<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientClose extends AbstractHookListener
{
    const KEY = 'ClientClose';

    protected $code = self::KEY;
}