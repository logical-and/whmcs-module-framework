<?php

namespace WHMCS\Module\Framework\Events\HookListener\Addon;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class LicensingAddonVerify extends AbstractHookListener
{
    const KEY = 'LicensingAddonVerify';

    protected $code = self::KEY;
}
