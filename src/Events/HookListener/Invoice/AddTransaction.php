<?php

namespace WHMCS\Module\Framework\Events\HookListener\Invoice;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddTransaction extends AbstractHookListener
{
    const KEY = 'AddTransaction';

    protected $code = self::KEY;
}