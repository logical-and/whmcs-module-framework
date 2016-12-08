<?php

namespace WHMCS\Module\Framework\Events\HookListener\Service;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminServiceEdit extends AbstractHookListener
{
    const KEY = 'AdminServiceEdit';

    protected $code = self::KEY;
}