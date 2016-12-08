<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientAreaSecondaryNavbar extends AbstractHookListener
{
    const KEY = 'ClientAreaSecondaryNavbar';

    protected $code = self::KEY;
}