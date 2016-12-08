<?php

namespace WHMCS\Module\Framework\Events\HookListener\Cron;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AfterCronJob extends AbstractHookListener
{
    const KEY = 'AfterCronJob';

    protected $code = self::KEY;
}