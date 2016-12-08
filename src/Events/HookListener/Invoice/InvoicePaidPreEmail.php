<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class InvoicePaidPreEmail extends AbstractHookListener
{
    const KEY = 'InvoicePaidPreEmail';

    protected $code = self::KEY;
}