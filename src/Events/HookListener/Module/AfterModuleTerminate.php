<?php

namespace WHMCS\Module\Framework\Events\HookListener\Module;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AfterModuleTerminate extends AbstractHookListener
{
    const KEY = 'AfterModuleTerminate';

    protected $code = self::KEY;
}