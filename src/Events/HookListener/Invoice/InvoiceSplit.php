<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class InvoiceSplit extends AbstractHookListener
{
    const KEY = 'InvoiceSplit';

    protected $code = self::KEY;
}