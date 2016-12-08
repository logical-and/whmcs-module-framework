<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddInvoiceLateFee extends AbstractHookListener
{
    const KEY = 'AddInvoiceLateFee';

    protected $code = self::KEY;
}