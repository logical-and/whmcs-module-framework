<?php

namespace WHMCS\Module\Framework\Events\HookListener\Miscellaneous;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class CalcAffiliateCommission extends AbstractHookListener
{
    const KEY = 'CalcAffiliateCommission';

    protected $code = self::KEY;
}