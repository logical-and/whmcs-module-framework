<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ShoppingCartValidateDomainsConfig extends AbstractHookListener
{
    const KEY = 'ShoppingCartValidateDomainsConfig';

    protected $code = self::KEY;
}