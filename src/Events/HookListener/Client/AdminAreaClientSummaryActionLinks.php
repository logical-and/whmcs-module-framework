<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminAreaClientSummaryActionLinks extends AbstractHookListener
{
    const KEY = 'AdminAreaClientSummaryActionLinks';

    protected $code = self::KEY;
}