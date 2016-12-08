<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class RunFraudCheck extends AbstractHookListener
{
    const KEY = 'RunFraudCheck';

    protected $code = self::KEY;
}