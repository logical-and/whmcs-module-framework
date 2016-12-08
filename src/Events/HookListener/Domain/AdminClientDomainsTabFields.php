<?php

namespace WHMCS\Module\Framework\Events\HookListener\Domain;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminClientDomainsTabFields extends AbstractHookListener
{
    const KEY = 'AdminClientDomainsTabFields';

    protected $code = self::KEY;
}