<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AcceptOrder extends AbstractHookListener
{
    const KEY = 'AcceptOrder';

    protected $code = self::KEY;
}