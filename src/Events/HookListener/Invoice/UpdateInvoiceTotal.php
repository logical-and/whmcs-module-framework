<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class UpdateInvoiceTotal extends AbstractHookListener
{
    const KEY = 'UpdateInvoiceTotal';

    protected $code = self::KEY;
}