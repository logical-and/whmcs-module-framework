<?php

namespace WHMCS\Module\Framework\Events\HookListener\Miscellaneous;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AfterConfigOptionsUpgrade extends AbstractHookListener
{
    const KEY = 'AfterConfigOptionsUpgrade';

    protected $code = self::KEY;
}