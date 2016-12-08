<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class acceptQuote extends AbstractHookListener
{
    const KEY = 'acceptQuote';

    protected $code = self::KEY;
}