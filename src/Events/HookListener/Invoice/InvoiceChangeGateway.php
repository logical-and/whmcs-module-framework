<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class InvoiceChangeGateway extends AbstractHookListener
{
    const KEY = 'InvoiceChangeGateway';

    protected $code = self::KEY;
}