<?php

namespace WHMCS\Module\Framework\Events\HookListener\Domain;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class PreDomainRegister extends AbstractHookListener
{
    const KEY = 'PreDomainRegister';

    protected $code = self::KEY;
}