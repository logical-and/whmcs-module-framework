<?php

namespace WHMCS\Module\Framework\Events\HookListener\Addon;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddonActivated extends AbstractHookListener
{
    const KEY = 'AddonActivated';

    protected $code = self::KEY;
}
