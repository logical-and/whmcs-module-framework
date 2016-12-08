<?php

namespace WHMCS\Module\Framework\Events\HookListener\Ticket;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class TicketPiping extends AbstractHookListener
{
    const KEY = 'TicketPiping';

    protected $code = self::KEY;
}