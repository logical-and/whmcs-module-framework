<?php

namespace WHMCS\Module\Framework;



class Addon extends AbstractModule
{
    const TYPE = 'addon';
    const TYPE_DIRECTORY = 'modules/addons';

    /**
     * Called only once
     */
    protected function register()
    {
        $this->registerConfigFunction($this->getId() . '_config', $this->getOriginalConfig());
    }
}