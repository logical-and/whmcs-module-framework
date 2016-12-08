<?php

namespace WHMCS\Module\Framework\Events\HookListener\Addon;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddonEdit extends AbstractHookListener
{
    const KEY = 'AddonEdit';

    protected $code = self::KEY;
}
