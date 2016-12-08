<?php

namespace WHMCS\Module\Framework\Events\HookListener\Ticket;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class TicketOpen extends AbstractHookListener
{
    const KEY = 'TicketOpen';

    protected $code = self::KEY;
}