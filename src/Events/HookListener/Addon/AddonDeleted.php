<?php

namespace WHMCS\Module\Framework\Events\HookListener\Addon;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddonDeleted extends AbstractHookListener
{
    const KEY = 'AddonDeleted';

    protected $code = self::KEY;
}
