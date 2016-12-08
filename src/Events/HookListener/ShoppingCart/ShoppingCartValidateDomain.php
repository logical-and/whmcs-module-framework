<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ShoppingCartValidateDomain extends AbstractHookListener
{
    const KEY = 'ShoppingCartValidateDomain';

    protected $code = self::KEY;
}