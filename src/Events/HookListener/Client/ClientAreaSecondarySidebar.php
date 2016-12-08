<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientAreaSecondarySidebar extends AbstractHookListener
{
    const KEY = 'ClientAreaSecondarySidebar';

    protected $code = self::KEY;
}