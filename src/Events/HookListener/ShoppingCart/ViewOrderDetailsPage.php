<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ViewOrderDetailsPage extends AbstractHookListener
{
    const KEY = 'ViewOrderDetailsPage';

    protected $code = self::KEY;
}