<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreDeleteClient extends AbstractHookListener
{
    const KEY = 'PreDeleteClient';

    protected $code = self::KEY;
}