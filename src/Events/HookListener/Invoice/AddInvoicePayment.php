<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddInvoicePayment extends AbstractHookListener
{
    const KEY = 'AddInvoicePayment';

    protected $code = self::KEY;
}