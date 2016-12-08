<?php

namespace WHMCS\Module\Framework\Events\HookListener\Addon;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddonCancelled extends AbstractHookListener
{
    const KEY = 'AddonCancelled';

    protected $code = self::KEY;
}
