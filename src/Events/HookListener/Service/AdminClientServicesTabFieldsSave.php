<?php

namespace WHMCS\Module\Framework\Events\HookListener\Service;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminClientServicesTabFieldsSave extends AbstractHookListener
{
    const KEY = 'AdminClientServicesTabFieldsSave';

    protected $code = self::KEY;
}