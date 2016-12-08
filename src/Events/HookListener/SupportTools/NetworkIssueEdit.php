<?php

namespace WHMCS\Module\Framework\Events\HookListener\SupportTools;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class NetworkIssueEdit extends AbstractHookListener
{
    const KEY = 'NetworkIssueEdit';

    protected $code = self::KEY;
}