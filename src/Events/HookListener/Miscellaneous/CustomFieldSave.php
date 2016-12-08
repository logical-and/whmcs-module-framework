<?php

namespace WHMCS\Module\Framework\Events\HookListener\Miscellaneous;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class CustomFieldSave extends AbstractHookListener
{
    const KEY = 'CustomFieldSave';

    protected $code = self::KEY;
}