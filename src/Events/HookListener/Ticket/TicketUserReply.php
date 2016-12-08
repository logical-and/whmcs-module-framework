<?php

namespace WHMCS\Module\Framework\Events\HookListener\Ticket;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class TicketUserReply extends AbstractHookListener
{
    const KEY = 'TicketUserReply';

    protected $code = self::KEY;
}