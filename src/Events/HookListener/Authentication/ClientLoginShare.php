<?php

namespace WHMCS\Module\Framework\Events\HookListener\Authentication;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientLoginShare extends AbstractHookListener
{
    const KEY = 'ClientLoginShare';

    protected $code = self::KEY;
}