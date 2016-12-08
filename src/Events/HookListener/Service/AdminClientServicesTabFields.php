<?php

namespace WHMCS\Module\Framework\Events\HookListener\Service;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminClientServicesTabFields extends AbstractHookListener
{
    const KEY = 'AdminClientServicesTabFields';

    protected $code = self::KEY;
}