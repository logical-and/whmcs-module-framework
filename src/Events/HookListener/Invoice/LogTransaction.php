<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class LogTransaction extends AbstractHookListener
{
    const KEY = 'LogTransaction';

    protected $code = self::KEY;
}