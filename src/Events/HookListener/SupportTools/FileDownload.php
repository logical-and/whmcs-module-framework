<?php

namespace WHMCS\Module\Framework\Events\HookListener\SupportTools;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class FileDownload extends AbstractHookListener
{
    const KEY = 'FileDownload';

    protected $code = self::KEY;
}