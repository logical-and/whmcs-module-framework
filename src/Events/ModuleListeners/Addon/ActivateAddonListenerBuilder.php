<?php

namespace WHMCS\Module\Framework\Events\ModuleListeners\Addon;

use WHMCS\Module\Framework\Events\CallbackModuleListener;

class ActivateAddonListenerBuilder extends AbstractAddonListener
{
    public static function build(callable $callback)
    {
        return CallbackModuleListener::createCallback('activate', $callback);
    }
}