<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ViewInvoiceDetailsPage extends AbstractHookListener
{
    const KEY = 'ViewInvoiceDetailsPage';

    protected $code = self::KEY;
}