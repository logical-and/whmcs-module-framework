<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ManualRefund extends AbstractHookListener
{
    const KEY = 'ManualRefund';

    protected $code = self::KEY;
}