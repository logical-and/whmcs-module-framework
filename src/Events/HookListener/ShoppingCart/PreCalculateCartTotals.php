<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreCalculateCartTotals extends AbstractHookListener
{
    const KEY = 'PreCalculateCartTotals';

    protected $code = self::KEY;
}