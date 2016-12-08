<?php

namespace WHMCS\Module\Framework\Events\HookListener\Addon;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddonTerminated extends AbstractHookListener
{
    const KEY = 'AddonTerminated';

    protected $code = self::KEY;
}
