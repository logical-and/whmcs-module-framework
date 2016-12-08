<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class InvoiceRefunded extends AbstractHookListener
{
    const KEY = 'InvoiceRefunded';

    protected $code = self::KEY;
}