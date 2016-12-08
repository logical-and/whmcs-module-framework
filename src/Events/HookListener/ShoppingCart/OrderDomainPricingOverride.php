<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class OrderDomainPricingOverride extends AbstractHookListener
{
    const KEY = 'OrderDomainPricingOverride';

    protected $code = self::KEY;
}