<?php

namespace WHMCS\Module\Framework\Events\Iterator;

use ErrorException;
use WHMCS\Module\Framework\Events\AbstractHookListener;

/**
 * Class ClassesHooks
 *
 * @deprecated
 */
class ClassesHooks
{

    public static function registerHooks(array $classes)
    {
        foreach ($classes as $class) {
            /** @var AbstractHookListener $instance */
            $instance = new $class();

            $abstractParent = AbstractHookListener::class;
            if (!$instance instanceof $abstractParent) {
                throw new ErrorException(sprintf('Class "%s" should be inherited from "%s" class',
                    $class, AbstractHookListener::class));
            }

            if (false !== $instance->preRegister()) {
                $instance->register();
            }
        }
    }
}