<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class InvoicePaymentReminder extends AbstractHookListener
{
    const KEY = 'InvoicePaymentReminder';

    protected $code = self::KEY;
}