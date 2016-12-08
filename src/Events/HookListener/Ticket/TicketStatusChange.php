<?php

namespace WHMCS\Module\Framework\Events\HookListener\Ticket;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class TicketStatusChange extends AbstractHookListener
{
    const KEY = 'TicketStatusChange';

    protected $code = self::KEY;
}