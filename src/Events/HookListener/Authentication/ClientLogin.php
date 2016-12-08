<?php

namespace WHMCS\Module\Framework\Events\HookListener\Authentication;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientLogin extends AbstractHookListener
{
    const KEY = 'ClientLogin';

    protected $code = self::KEY;
}