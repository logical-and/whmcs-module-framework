<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ShoppingCartCheckoutCompletePage extends AbstractHookListener
{
    const KEY = 'ShoppingCartCheckoutCompletePage';

    protected $code = self::KEY;
}