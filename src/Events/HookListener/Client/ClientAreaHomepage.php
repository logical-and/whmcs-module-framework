<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientAreaHomepage extends AbstractHookListener
{
    const KEY = 'ClientAreaHomepage';

    protected $code = self::KEY;
}