<?php

namespace WHMCS\Module\Framework\Events\HookListener\Ticket;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AdminAreaViewTicketPage extends AbstractHookListener
{
    const KEY = 'AdminAreaViewTicketPage';

    protected $code = self::KEY;
}