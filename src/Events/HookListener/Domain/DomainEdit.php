<?php

namespace WHMCS\Module\Framework\Events\HookListener\Domain;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class DomainEdit extends AbstractHookListener
{
    const KEY = 'DomainEdit';

    protected $code = self::KEY;
}