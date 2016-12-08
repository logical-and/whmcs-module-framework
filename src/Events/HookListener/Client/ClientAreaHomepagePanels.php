<?php

namespace WHMCS\Module\Framework\Events\HookListener\Client;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ClientAreaHomepagePanels extends AbstractHookListener
{
    const KEY = 'ClientAreaHomepagePanels';

    protected $code = self::KEY;
}