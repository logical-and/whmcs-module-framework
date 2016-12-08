<?php

namespace WHMCS\Module\Framework\Events\HookListener\Miscellaneous;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class CCUpdate extends AbstractHookListener
{
    const KEY = 'CCUpdate';

    protected $code = self::KEY;
}