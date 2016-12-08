<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class InvoiceUnpaid extends AbstractHookListener
{
    const KEY = 'InvoiceUnpaid';

    protected $code = self::KEY;
}