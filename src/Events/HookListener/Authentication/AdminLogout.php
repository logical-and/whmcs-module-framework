<?php

namespace WHMCS\Module\Framework\Events\HookListener\Authentication;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminLogout extends AbstractHookListener
{
    const KEY = 'AdminLogout';

    protected $code = self::KEY;
}