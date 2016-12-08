<?php

namespace WHMCS\Module\Framework\Events\HookListener\Module;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreModuleChangePackage extends AbstractHookListener
{
    const KEY = 'PreModuleChangePackage';

    protected $code = self::KEY;
}