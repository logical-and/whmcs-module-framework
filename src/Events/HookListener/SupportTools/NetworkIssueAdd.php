<?php

namespace WHMCS\Module\Framework\Events\HookListener\SupportTools;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class NetworkIssueAdd extends AbstractHookListener
{
    const KEY = 'NetworkIssueAdd';

    protected $code = self::KEY;
}