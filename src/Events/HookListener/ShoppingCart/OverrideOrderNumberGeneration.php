<?php

namespace WHMCS\Module\Framework\Events\HookListener\ShoppingCart;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class OverrideOrderNumberGeneration extends AbstractHookListener
{
    const KEY = 'OverrideOrderNumberGeneration';

    protected $code = self::KEY;
}