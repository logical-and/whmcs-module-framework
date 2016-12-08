<?php

namespace WHMCS\Module\Framework\Events\HookListener\Module;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreModuleTerminate extends AbstractHookListener
{
    const KEY = 'PreModuleTerminate';

    protected $code = self::KEY;
}