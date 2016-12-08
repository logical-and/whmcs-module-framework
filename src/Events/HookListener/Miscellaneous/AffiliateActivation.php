<?php

namespace WHMCS\Module\Framework\Events\HookListener\Miscellaneous;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AffiliateActivation extends AbstractHookListener
{
    const KEY = 'AffiliateActivation';

    protected $code = self::KEY;
}