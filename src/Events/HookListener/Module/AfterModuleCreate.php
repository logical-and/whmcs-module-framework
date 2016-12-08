<?php

namespace WHMCS\Module\Framework\Events\HookListener\Module;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AfterModuleCreate extends AbstractHookListener
{
    const KEY = 'AfterModuleCreate';

    protected $code = self::KEY;
}