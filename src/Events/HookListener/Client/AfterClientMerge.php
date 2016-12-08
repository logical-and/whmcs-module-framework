<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AfterClientMerge extends AbstractHookListener
{
    const KEY = 'AfterClientMerge';

    protected $code = self::KEY;
}