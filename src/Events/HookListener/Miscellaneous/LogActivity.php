<?php

namespace WHMCS\Module\Framework\Events\HookListener\Miscellaneous;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class LogActivity extends AbstractHookListener
{
    const KEY = 'LogActivity';

    protected $code = self::KEY;
}