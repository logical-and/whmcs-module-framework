<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class InvoicePaid extends AbstractHookListener
{
    const KEY = 'InvoicePaid';

    protected $code = self::KEY;
}