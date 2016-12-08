<?php

namespace WHMCS\Module\Framework\Events\HookListener\SupportTools;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AnnouncementEdit extends AbstractHookListener
{
    const KEY = 'AnnouncementEdit';

    protected $code = self::KEY;
}