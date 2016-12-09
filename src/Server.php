<?php

namespace WHMCS\Module\Framework;

use ErrorException;
use WHMCS\Module\Framework\Events\AbstractModuleListener;

class Server extends AbstractModule
{
    const TYPE = 'server';

    /**
     * Called only once
     */
    protected function register()
    {
        $originalConfig = $this->getOriginalConfig();
        $metadata = array_diff_key($originalConfig, array_flip(['fields']));
        $fields = !empty($originalConfig['fields']) ? $originalConfig['fields'] : [];

        // Register functions
        $this->registerConfigFunction($this->getId() . '_Metadata', $metadata);
        if ($fields) {
            $this->registerConfigFunction($this->getId() . '_ConfigOptions', $fields);
        }
    }

    public function registerModuleListeners($classes = [])
    {
        foreach ($classes as $class) {
            /** @var AbstractModuleListener $instance */
            $instance = new $class();

            $abstractParent = AbstractModuleListener::class;
            if (!$instance instanceof $abstractParent) {
                throw new ErrorException(sprintf('Class "%s" should be inherited from "%s" class',
                    $class, AbstractModuleListener::class));
            }

            $instance->setModule($this)->register();
        }
    }
}
