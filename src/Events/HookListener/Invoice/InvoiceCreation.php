<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class InvoiceCreation extends AbstractHookListener
{
    const KEY = 'InvoiceCreation';

    protected $code = self::KEY;
}