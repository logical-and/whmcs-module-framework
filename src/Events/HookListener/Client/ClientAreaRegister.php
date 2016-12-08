<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientAreaRegister extends AbstractHookListener
{
    const KEY = 'ClientAreaRegister';

    protected $code = self::KEY;
}