<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AfterInvoicingGenerateInvoiceItems extends AbstractHookListener
{
    const KEY = 'AfterInvoicingGenerateInvoiceItems';

    protected $code = self::KEY;
}