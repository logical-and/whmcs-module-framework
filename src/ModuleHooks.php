<?php

namespace WHMCS\Module\Framework;

use ErrorException;
use WHMCS\Module\Framework\Events\AbstractHookListener;

class ModuleHooks
{

    /**
     * Register hook listeners
     *
     * @param string $file __FILE__
     * @param AbstractHookListener[] $classes
     * @throws ErrorException
     */
    public static function registerHooks($file, array $classes)
    {
        foreach ($classes as $class) {
            /** @var AbstractHookListener $class */
            /** @var AbstractHookListener $instance */
            $instance = is_string($class) ? $class::getInstance() : $class;

            $abstractParent = AbstractHookListener::class;
            if (!$instance instanceof $abstractParent) {
                throw new ErrorException(sprintf('Class "%s" should be inherited from "%s" class',
                    $class, AbstractHookListener::class));
            }

            $instance->defineHooksFile($file);
            $instance->register();
        }
    }
}