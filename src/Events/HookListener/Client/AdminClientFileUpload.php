<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminClientFileUpload extends AbstractHookListener
{
    const KEY = 'AdminClientFileUpload';

    protected $code = self::KEY;
}