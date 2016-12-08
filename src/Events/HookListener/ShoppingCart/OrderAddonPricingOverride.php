<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class OrderAddonPricingOverride extends AbstractHookListener
{
    const KEY = 'OrderAddonPricingOverride';

    protected $code = self::KEY;
}