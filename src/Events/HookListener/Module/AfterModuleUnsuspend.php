<?php

namespace WHMCS\Module\Framework\Events\HookListener\Module;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AfterModuleUnsuspend extends AbstractHookListener
{
    const KEY = 'AfterModuleUnsuspend';

    protected $code = self::KEY;
}