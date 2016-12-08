<?php

namespace WHMCS\Module\Framework\Events\HookListener\Addon;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddonAdd extends AbstractHookListener
{
    const KEY = 'AddonAdd';

    protected $code = self::KEY;
}
