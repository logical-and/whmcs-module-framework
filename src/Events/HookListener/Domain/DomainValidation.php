<?php

namespace WHMCS\Module\Framework\Events\HookListener\Domain;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class DomainValidation extends AbstractHookListener
{
    const KEY = 'DomainValidation';

    protected $code = self::KEY;
}