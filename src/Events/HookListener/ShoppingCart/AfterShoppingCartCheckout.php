<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AfterShoppingCartCheckout extends AbstractHookListener
{
    const KEY = 'AfterShoppingCartCheckout';

    protected $code = self::KEY;
}