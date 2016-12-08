<?php

namespace WHMCS\Module\Framework\Events\HookListener\Authentication;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientLogout extends AbstractHookListener
{
    const KEY = 'ClientLogout';

    protected $code = self::KEY;
}