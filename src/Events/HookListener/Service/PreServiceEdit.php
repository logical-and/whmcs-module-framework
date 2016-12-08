<?php

namespace WHMCS\Module\Framework\Events\HookListener\Service;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreServiceEdit extends AbstractHookListener
{
    const KEY = 'PreServiceEdit';

    protected $code = self::KEY;
}