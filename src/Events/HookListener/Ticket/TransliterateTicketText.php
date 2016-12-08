<?php

namespace WHMCS\Module\Framework\Events\HookListener\Ticket;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class TransliterateTicketText extends AbstractHookListener
{
    const KEY = 'TransliterateTicketText';

    protected $code = self::KEY;
}