<?php

namespace WHMCS\Module\Framework\Events\HookListener\Contact;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class ContactChangePassword extends AbstractHookListener
{
    const KEY = 'ContactChangePassword';

    protected $code = self::KEY;
}