<?php

namespace WHMCS\Module\Framework\Events\HookListener\Ticket;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class TicketAddNote extends AbstractHookListener
{
    const KEY = 'TicketAddNote';

    protected $code = self::KEY;
}