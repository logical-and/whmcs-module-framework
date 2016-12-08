<?php

namespace WHMCS\Module\Framework\Events\HookListener\Addon;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddonUnsuspended extends AbstractHookListener
{
    const KEY = 'AddonUnsuspended';

    protected $code = self::KEY;
}
