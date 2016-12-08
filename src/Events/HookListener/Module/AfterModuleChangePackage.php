<?php

namespace WHMCS\Module\Framework\Events\HookListener\Module;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AfterModuleChangePackage extends AbstractHookListener
{
    const KEY = 'AfterModuleChangePackage';

    protected $code = self::KEY;
}