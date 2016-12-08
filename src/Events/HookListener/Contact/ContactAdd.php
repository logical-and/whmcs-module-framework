<?php

namespace WHMCS\Module\Framework\Events\HookListener\Contact;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ContactAdd extends AbstractHookListener
{
    const KEY = 'ContactAdd';

    protected $code = self::KEY;
}