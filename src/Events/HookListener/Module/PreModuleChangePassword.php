<?php

namespace WHMCS\Module\Framework\Events\HookListener\Module;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreModuleChangePassword extends AbstractHookListener
{
    const KEY = 'PreModuleChangePassword';

    protected $code = self::KEY;
}