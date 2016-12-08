<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientAlert extends AbstractHookListener
{
    const KEY = 'ClientAlert';

    protected $code = self::KEY;
}