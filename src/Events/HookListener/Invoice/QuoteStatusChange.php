<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class QuoteStatusChange extends AbstractHookListener
{
    const KEY = 'QuoteStatusChange';

    protected $code = self::KEY;
}