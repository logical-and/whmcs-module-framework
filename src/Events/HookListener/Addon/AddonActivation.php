<?php

namespace WHMCS\Module\Framework\Events\HookListener\Addon;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddonActivation extends AbstractHookListener
{
    const KEY = 'AddonActivation';

    protected $code = self::KEY;
}
