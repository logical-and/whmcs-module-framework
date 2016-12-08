<?php

namespace WHMCS\Module\Framework\Events\HookListener\Module;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AfterModuleChangePassword extends AbstractHookListener
{
    const KEY = 'AfterModuleChangePassword';

    protected $code = self::KEY;
}