<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PendingOrder extends AbstractHookListener
{
    const KEY = 'PendingOrder';

    protected $code = self::KEY;
}