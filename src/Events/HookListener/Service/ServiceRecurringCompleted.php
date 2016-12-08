<?php

namespace WHMCS\Module\Framework\Events\HookListener\Service;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ServiceRecurringCompleted extends AbstractHookListener
{
    const KEY = 'ServiceRecurringCompleted';

    protected $code = self::KEY;
}