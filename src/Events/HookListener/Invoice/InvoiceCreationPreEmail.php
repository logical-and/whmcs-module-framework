<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class InvoiceCreationPreEmail extends AbstractHookListener
{
    const KEY = 'InvoiceCreationPreEmail';

    protected $code = self::KEY;
}