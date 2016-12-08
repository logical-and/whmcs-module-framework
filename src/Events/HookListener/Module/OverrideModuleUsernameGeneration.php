<?php

namespace WHMCS\Module\Framework\Events\HookListener\Module;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class OverrideModuleUsernameGeneration extends AbstractHookListener
{
    const KEY = 'OverrideModuleUsernameGeneration';

    protected $code = self::KEY;
}