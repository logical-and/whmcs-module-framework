<?php

namespace WHMCS\Module\Framework\Events\HookListener\Product;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ServerEdit extends AbstractHookListener
{
    const KEY = 'ServerEdit';

    protected $code = self::KEY;
}