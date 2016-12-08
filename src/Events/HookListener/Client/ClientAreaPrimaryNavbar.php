<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientAreaPrimaryNavbar extends AbstractHookListener
{
    const KEY = 'ClientAreaPrimaryNavbar';

    protected $code = self::KEY;
}