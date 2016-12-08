<?php

namespace WHMCS\Module\Framework\Events\HookListener\Product;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ServerDelete extends AbstractHookListener
{
    const KEY = 'ServerDelete';

    protected $code = self::KEY;
}