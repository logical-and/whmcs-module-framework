<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientEdit extends AbstractHookListener
{
    const KEY = 'ClientEdit';

    protected $code = self::KEY;
}