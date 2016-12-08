<?php

namespace WHMCS\Module\Framework\Events\HookListener\SupportTools;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class NetworkIssueReopen extends AbstractHookListener
{
    const KEY = 'NetworkIssueReopen';

    protected $code = self::KEY;
}