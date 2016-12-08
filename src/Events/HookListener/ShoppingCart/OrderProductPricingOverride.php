<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class OrderProductPricingOverride extends AbstractHookListener
{
    const KEY = 'OrderProductPricingOverride';

    protected $code = self::KEY;
}