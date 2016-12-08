<?php

namespace WHMCS\Module\Framework\Events\HookListener\Product;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminProductConfigFieldsSave extends AbstractHookListener
{
    const KEY = 'AdminProductConfigFieldsSave';

    protected $code = self::KEY;
}