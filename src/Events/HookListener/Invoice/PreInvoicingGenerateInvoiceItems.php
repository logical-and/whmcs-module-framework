<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreInvoicingGenerateInvoiceItems extends AbstractHookListener
{
    const KEY = 'PreInvoicingGenerateInvoiceItems';

    protected $code = self::KEY;
}