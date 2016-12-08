<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class QuoteCreated extends AbstractHookListener
{
    const KEY = 'QuoteCreated';

    protected $code = self::KEY;
}