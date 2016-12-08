<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class InvoiceCancelled extends AbstractHookListener
{
    const KEY = 'InvoiceCancelled';

    protected $code = self::KEY;
}