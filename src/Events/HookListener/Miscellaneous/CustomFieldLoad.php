<?php

namespace WHMCS\Module\Framework\Events\HookListener\Miscellaneous;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class CustomFieldLoad extends AbstractHookListener
{
    const KEY = 'CustomFieldLoad';

    protected $code = self::KEY;
}