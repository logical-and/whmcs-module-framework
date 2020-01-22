<?php

namespace WHMCS\Module\Framework\Events\ModuleListeners\Addon;

use WHMCS\Module\Framework\Addon;
use WHMCS\Module\Framework\Helper;

abstract class AbstractAddonListener
{

    public static function getAddonTrackedVersion(Addon $addon)
    {
        $moduleId = $addon->getId();
        $scopedId = "{$moduleId}_tracked";

        $fetched = Helper::conn()->selectOne(
            'SELECT value
            FROM tbladdonmodules
            WHERE module = ? AND setting = "version"',
            [$scopedId]
        );

        if ($fetched and !empty($fetched[ 'value' ])) {
            return $fetched[ 'value' ];
        }

        // Wasn't saved yet
        return '0';
    }

    public static function updateTrackedVersion(Addon $addon, $version)
    {
        $previousVersion = self::getAddonTrackedVersion($addon);
        $saved = $previousVersion != '0';
        $moduleId = $addon->getId();
        $scopedId = "{$moduleId}_tracked";

        if (!$saved) {
            Helper::conn()->insert("
                INSERT INTO tbladdonmodules
                (module, setting, value)
                VALUES (?, 'version', ?)",
                [$scopedId, $version]);
        }
        else {
            Helper::conn()->update("
                UPDATE tbladdonmodules
                SET value = ?
                WHERE module = ? AND setting = 'version'",
                [$version, $scopedId]);
        }
    }
}
