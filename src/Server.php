<?php

namespace WHMCS\Module\Framework;

use WHMCS\Module\Framework\ConfigBuilder\ServerConfigBuilder;

class Server extends AbstractModule
{
    const TYPE = 'server';
    const TYPE_DIRECTORY = 'modules/servers';

    /**
     * @return ServerConfigBuilder
     */
    public static function configBuilder()
    {
        return ServerConfigBuilder::builder();
    }

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
