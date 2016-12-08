<?php

namespace WHMCS\Module\Framework\Events\HookListener\Module;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreModuleCreate extends AbstractHookListener
{
    const KEY = 'PreModuleCreate';

    protected $code = self::KEY;
}