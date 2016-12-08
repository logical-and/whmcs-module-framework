<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AddonFraud extends AbstractHookListener
{
    const KEY = 'AddonFraud';

    protected $code = self::KEY;
}