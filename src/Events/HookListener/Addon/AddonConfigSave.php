<?php

namespace WHMCS\Module\Framework\Events\HookListener\Addon;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddonConfigSave extends AbstractHookListener
{
    const KEY = 'AddonConfigSave';

    protected $code = self::KEY;
}
