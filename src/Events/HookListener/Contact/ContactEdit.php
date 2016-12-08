<?php

namespace WHMCS\Module\Framework\Events\HookListener\Contact;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ContactEdit extends AbstractHookListener
{
    const KEY = 'ContactEdit';

    protected $code = self::KEY;
}