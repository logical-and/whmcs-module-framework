<?php

namespace WHMCS\Module\Framework\Events\HookListener\Domain;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class DomainDelete extends AbstractHookListener
{
    const KEY = 'DomainDelete';

    protected $code = self::KEY;
}