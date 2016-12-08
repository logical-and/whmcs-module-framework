<?php

namespace WHMCS\Module\Framework\Events\HookListener\Product;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ServerAdd extends AbstractHookListener
{
    const KEY = 'ServerAdd';

    protected $code = self::KEY;
}