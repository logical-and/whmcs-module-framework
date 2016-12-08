<?php

namespace WHMCS\Module\Framework\Events\HookListener\Product;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AfterProductUpgrade extends AbstractHookListener
{
    const KEY = 'AfterProductUpgrade';

    protected $code = self::KEY;
}