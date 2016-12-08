<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AfterFraudCheck extends AbstractHookListener
{
    const KEY = 'AfterFraudCheck';

    protected $code = self::KEY;
}