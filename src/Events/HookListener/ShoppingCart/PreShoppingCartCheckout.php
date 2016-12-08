<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreShoppingCartCheckout extends AbstractHookListener
{
    const KEY = 'PreShoppingCartCheckout';

    protected $code = self::KEY;
}