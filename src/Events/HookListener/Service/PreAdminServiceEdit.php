<?php

namespace WHMCS\Module\Framework\Events\HookListener\Service;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreAdminServiceEdit extends AbstractHookListener
{
    const KEY = 'PreAdminServiceEdit';

    protected $code = self::KEY;
}