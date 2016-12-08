<?php

namespace WHMCS\Module\Framework\Events\HookListener\Miscellaneous;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class LinkTracker extends AbstractHookListener
{
    const KEY = 'LinkTracker';

    protected $code = self::KEY;
}