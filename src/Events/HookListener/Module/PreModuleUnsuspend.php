<?php

namespace WHMCS\Module\Framework\Events\HookListener\Module;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreModuleUnsuspend extends AbstractHookListener
{
    const KEY = 'PreModuleUnsuspend';

    protected $code = self::KEY;
}