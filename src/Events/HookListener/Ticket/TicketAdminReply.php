<?php

namespace WHMCS\Module\Framework\Events\HookListener\Ticket;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class TicketAdminReply extends AbstractHookListener
{
    const KEY = 'TicketAdminReply';

    protected $code = self::KEY;
}