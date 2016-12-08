<?php

namespace WHMCS\Module\Framework\Events\HookListener\Product;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ProductDelete extends AbstractHookListener
{
    const KEY = 'ProductDelete';

    protected $code = self::KEY;
}