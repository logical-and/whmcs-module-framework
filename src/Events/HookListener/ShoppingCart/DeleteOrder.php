<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class DeleteOrder extends AbstractHookListener
{
    const KEY = 'DeleteOrder';

    protected $code = self::KEY;
}