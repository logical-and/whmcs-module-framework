<?php

namespace WHMCS\Module\Framework;



class Addon extends AbstractModule
{
    const TYPE = 'addon';

    /**
     * Called only once
     */
    protected function register()
    {
        $this->registerConfigFunction($this->getId() . '_config', $this->getOriginalConfig());
    }
}