<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class InvoiceCreationAdminArea extends AbstractHookListener
{
    const KEY = 'InvoiceCreationAdminArea';

    protected $code = self::KEY;
}