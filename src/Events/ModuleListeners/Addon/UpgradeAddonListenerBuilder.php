<?php

namespace WHMCS\Module\Framework\Events\ModuleListeners\Addon;

use WHMCS\Module\Framework\Events\CallbackModuleListener;

class UpgradeAddonListenerBuilder extends AbstractAddonListener
{
    /**
     * Build listeners
     * @param array $versionsHandlers [function($type = 'upgrade/downgrade', $previousVersion, $currentVersion) {}]
     * @return CallbackModuleListener
     */
    public static function build(array $versionsHandlers)
    {
        // Validate versions
        foreach ($versionsHandlers as $version => $handler) {
            if (!preg_match('~^\d+(\.\d+)*$~', (string) $version)) {
                throw new \InvalidArgumentException("Version \"$version\" is not a valid version");
            }
            if (!is_callable($handler)) {
                throw new \InvalidArgumentException("Version \"$version\" has no valid callable handler");
            }
        }

        return CallbackModuleListener::createCallback('upgrade', function ($vars, $context = null) use($versionsHandlers) {
            /** @var CallbackModuleListener $self */
            $self = $this;
            // Fix PHP 5.6 Closure::bind()
            if (PHP_MAJOR_VERSION < 7) {
                $self = $context;
            }

            // Prepare version string
            $previousVersion = !empty($vars['version']) ? $vars['version'] : '0';
            $previousVersion = self::clearVersionString($previousVersion);


            $currentVersion = $self->getModule()->getOriginalConfig('version', '0');
            $currentVersion = self::clearVersionString($currentVersion);

            switch (version_compare($previousVersion, $currentVersion)) {
                case 1:
                    $type = 'downgrade';
                    break;

                case -1:
                    $type = 'upgrade';
                    break;

                case 0:
                default:
                    $type = 'nothing';
                    break;
            }
            // A bug in WHMCS?
            if ('nothing' == $type) {
                return;
            }

            // Ascending
            if ('upgrade' == $type) {
                // Sort versions
                uksort($versionsHandlers, function ($v1, $v2) {
                    return version_compare((string) $v1, (string) $v2);
                });
            }
            // Descending
            else {
                // Sort versions
                uksort($versionsHandlers, function ($v1, $v2) {
                    return version_compare((string) $v2, (string) $v1);
                });
            }

            // Apply the changes
            foreach ($versionsHandlers as $version => $handler) {
                $handler = \Closure::bind($handler, $self);

                /** @var \Closure $handler */

                // Process only upgrades
                if ('upgrade' == $type) {
                    if (
                        // > previous
                        in_array(version_compare((string) $version, $previousVersion), [1], true) and
                        // <= current
                        in_array(version_compare((string) $version, $currentVersion), [-1, 0], true)
                    ) {
                        $handler($type, $previousVersion, $currentVersion, $self);
                    }
                } else {
                    if (
                        // <= previous
                        in_array(version_compare((string) $version, $previousVersion), [-1, 0], true) and
                        // >= current
                        in_array(version_compare((string) $version, $currentVersion), [0, 1], true)
                    ) {
                        $handler($type, $previousVersion, $currentVersion, $self);
                    }
                }
            }

            /** @noinspection PhpParamsInspection */
            self::updateTrackedVersion($self->getModule(), $currentVersion);
        });
    }

    public static function clearVersionString($version)
    {
        $version = (string) $version;
        $version = preg_replace('~<(\w+)\b.*?>.*?</\1>~si', '', $version);
        $version = trim($version);

        return $version;
    }
}
