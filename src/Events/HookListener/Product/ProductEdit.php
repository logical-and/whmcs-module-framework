<?php

namespace WHMCS\Module\Framework\Events\HookListener\Product;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ProductEdit extends AbstractHookListener
{
    const KEY = 'ProductEdit';

    protected $code = self::KEY;
}