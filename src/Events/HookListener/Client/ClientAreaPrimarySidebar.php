<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientAreaPrimarySidebar extends AbstractHookListener
{
    const KEY = 'ClientAreaPrimarySidebar';

    protected $code = self::KEY;
}