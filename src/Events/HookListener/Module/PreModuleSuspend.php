<?php

namespace WHMCS\Module\Framework\Events\HookListener\Module;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreModuleSuspend extends AbstractHookListener
{
    const KEY = 'PreModuleSuspend';

    protected $code = self::KEY;
}