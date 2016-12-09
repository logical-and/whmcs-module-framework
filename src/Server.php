<?php

namespace WHMCS\Module\Framework;

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
}
