<?php

namespace WHMCS\Module\Framework\PageHooks\Client;

class CustomClientPageHook extends AbstractClientPageHook
{
    protected $templateName;

    public function setTemplate($template)
    {
        $this->templateName = $template;

        return $this;
    }
}
