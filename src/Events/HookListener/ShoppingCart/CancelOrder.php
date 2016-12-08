<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class CancelOrder extends AbstractHookListener
{
    const KEY = 'CancelOrder';

    protected $code = self::KEY;
}