<?php

namespace WHMCS\Module\Framework\Events\HookListener\Domain;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientAreaDomainDetails extends AbstractHookListener
{
    const KEY = 'ClientAreaDomainDetails';

    protected $code = self::KEY;
}