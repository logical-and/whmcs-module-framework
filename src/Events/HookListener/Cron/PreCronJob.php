<?php

namespace WHMCS\Module\Framework\Events\HookListener\Cron;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreCronJob extends AbstractHookListener
{
    const KEY = 'PreCronJob';

    protected $code = self::KEY;
}