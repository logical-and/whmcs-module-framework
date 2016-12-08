<?php

namespace WHMCS\Module\Framework\Events\HookListener\Service;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ServiceDelete extends AbstractHookListener
{
    const KEY = 'ServiceDelete';

    protected $code = self::KEY;
}