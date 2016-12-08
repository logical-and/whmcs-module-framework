<?php

namespace WHMCS\Module\Framework\Events\HookListener\Ticket;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class SubmitTicketAnswerSuggestions extends AbstractHookListener
{
    const KEY = 'SubmitTicketAnswerSuggestions';

    protected $code = self::KEY;
}