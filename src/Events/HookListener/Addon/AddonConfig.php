<?php

namespace WHMCS\Module\Framework\Events\HookListener\Addon;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddonConfig extends AbstractHookListener
{
    const KEY = 'AddonConfig';

    protected $code = self::KEY;
}
