<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientChangePassword extends AbstractHookListener
{
    const KEY = 'ClientChangePassword';

    protected $code = self::KEY;
}