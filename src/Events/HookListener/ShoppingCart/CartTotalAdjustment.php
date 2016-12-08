<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class CartTotalAdjustment extends AbstractHookListener
{
    const KEY = 'CartTotalAdjustment';

    protected $code = self::KEY;
}