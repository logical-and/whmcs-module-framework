<?php

namespace WHMCS\Module\Framework\Events\HookListener\Service;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ServiceEdit extends AbstractHookListener
{
    const KEY = 'ServiceEdit';

    protected $code = self::KEY;
}