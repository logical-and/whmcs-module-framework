<?php

namespace WHMCS\Module\Framework\Events\HookListener\SupportTools;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AnnouncementAdd extends AbstractHookListener
{
    const KEY = 'AnnouncementAdd';

    protected $code = self::KEY;
}