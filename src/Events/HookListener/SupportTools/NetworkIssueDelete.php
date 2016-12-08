<?php

namespace WHMCS\Module\Framework\Events\HookListener\SupportTools;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class NetworkIssueDelete extends AbstractHookListener
{
    const KEY = 'NetworkIssueDelete';

    protected $code = self::KEY;
}