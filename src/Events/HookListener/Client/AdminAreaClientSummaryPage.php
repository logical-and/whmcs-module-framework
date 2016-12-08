<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminAreaClientSummaryPage extends AbstractHookListener
{
    const KEY = 'AdminAreaClientSummaryPage';

    protected $code = self::KEY;
}