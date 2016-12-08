<?php

namespace WHMCS\Module\Framework\Events\HookListener\Cron;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class DailyCronJob extends AbstractHookListener
{
    const KEY = 'DailyCronJob';

    protected $code = self::KEY;
}