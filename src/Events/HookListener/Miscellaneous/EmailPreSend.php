<?php

namespace WHMCS\Module\Framework\Events\HookListener\Miscellaneous;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class EmailPreSend extends AbstractHookListener
{
    const KEY = 'EmailPreSend';

    protected $code = self::KEY;
}