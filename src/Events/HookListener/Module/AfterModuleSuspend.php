<?php

namespace WHMCS\Module\Framework\Events\HookListener\Module;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AfterModuleSuspend extends AbstractHookListener
{
    const KEY = 'AfterModuleSuspend';

    protected $code = self::KEY;
}