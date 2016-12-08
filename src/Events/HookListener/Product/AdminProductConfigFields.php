<?php

namespace WHMCS\Module\Framework\Events\HookListener\Product;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminProductConfigFields extends AbstractHookListener
{
    const KEY = 'AdminProductConfigFields';

    protected $code = self::KEY;
}