<?php

namespace WHMCS\Module\Framework\Events\HookListener\Cron;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class DailyCronJobPreEmail extends AbstractHookListener
{
    const KEY = 'DailyCronJobPreEmail';

    protected $code = self::KEY;
}