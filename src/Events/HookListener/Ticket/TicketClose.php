<?php

namespace WHMCS\Module\Framework\Events\HookListener\Ticket;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class TicketClose extends AbstractHookListener
{
    const KEY = 'TicketClose';

    protected $code = self::KEY;
}