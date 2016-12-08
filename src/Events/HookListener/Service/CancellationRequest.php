<?php

namespace WHMCS\Module\Framework\Events\HookListener\Service;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class CancellationRequest extends AbstractHookListener
{
    const KEY = 'CancellationRequest';

    protected $code = self::KEY;
}