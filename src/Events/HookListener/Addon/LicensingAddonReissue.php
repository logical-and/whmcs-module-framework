<?php

namespace WHMCS\Module\Framework\Events\HookListener\Addon;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class LicensingAddonReissue extends AbstractHookListener
{
    const KEY = 'LicensingAddonReissue';

    protected $code = self::KEY;
}
