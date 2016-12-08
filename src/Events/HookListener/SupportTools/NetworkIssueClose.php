<?php

namespace WHMCS\Module\Framework\Events\HookListener\SupportTools;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class NetworkIssueClose extends AbstractHookListener
{
    const KEY = 'NetworkIssueClose';

    protected $code = self::KEY;
}