<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class FraudOrder extends AbstractHookListener
{
    const KEY = 'FraudOrder';

    protected $code = self::KEY;
}