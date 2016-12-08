<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class InvoiceCreated extends AbstractHookListener
{
    const KEY = 'InvoiceCreated';

    protected $code = self::KEY;
}