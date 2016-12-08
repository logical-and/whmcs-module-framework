<?php

namespace WHMCS\Module\Framework\Events\HookListener\Domain;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminClientDomainsTabFieldsSave extends AbstractHookListener
{
    const KEY = 'AdminClientDomainsTabFieldsSave';

    protected $code = self::KEY;
}