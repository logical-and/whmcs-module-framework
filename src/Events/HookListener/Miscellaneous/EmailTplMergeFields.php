<?php

namespace WHMCS\Module\Framework\Events\HookListener\Miscellaneous;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class EmailTplMergeFields extends AbstractHookListener
{
    const KEY = 'EmailTplMergeFields';

    protected $code = self::KEY;
}