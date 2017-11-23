<?php

namespace WHMCS\Module\Framework\PageHooks\Admin;

use WHMCS\Module\Framework\PageHooks\AbstractPageHook;

abstract class AbstractAdminPageHook extends AbstractPageHook
{
    protected function getHookForPosition($position)
    {
        switch ($position) {
            case self::POSITION_HEAD_BOTTOM: return 'AdminAreaHeadOutput';
            case self::POSITION_BODY_TOP: return 'AdminAreaHeaderOutput';
            case self::POSITION_BODY_BOTTOM: return 'AdminAreaFooterOutput';

            default: return false;
        }
    }
}
