<?php

namespace WHMCS\Module\Framework\Events\HookListener\Addon;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddonSuspended extends AbstractHookListener
{
    const KEY = 'AddonSuspended';

    protected $code = self::KEY;
}
