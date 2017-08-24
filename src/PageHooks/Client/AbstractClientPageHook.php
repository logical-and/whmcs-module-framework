<?php

namespace WHMCS\Module\Framework\PageHooks\Client;

use WHMCS\Module\Framework\PageHooks\AbstractPageHook;

abstract class AbstractClientPageHook extends AbstractPageHook
{
    protected function getHookForPosition($position)
    {
        switch ($position) {
            case self::POSITION_HEAD_BOTTOM: return 'ClientAreaHeadOutput';
            case self::POSITION_BODY_TOP: return 'ClientAreaHeaderOutput';
            case self::POSITION_BODY_BOTTOM: return 'ClientAreaFooterOutput';

            default: return false;
        }
    }
}
