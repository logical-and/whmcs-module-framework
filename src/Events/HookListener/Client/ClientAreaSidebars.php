<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientAreaSidebars extends AbstractHookListener
{
    const KEY = 'ClientAreaSidebars';

    protected $code = self::KEY;
}