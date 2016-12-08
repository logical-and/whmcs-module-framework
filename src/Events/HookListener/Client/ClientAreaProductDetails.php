<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientAreaProductDetails extends AbstractHookListener
{
    const KEY = 'ClientAreaProductDetails';

    protected $code = self::KEY;
}