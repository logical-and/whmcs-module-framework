<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminAreaViewQuotePage extends AbstractHookListener
{
    const KEY = 'AdminAreaViewQuotePage';

    protected $code = self::KEY;
}