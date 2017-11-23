<?php

namespace WHMCS\Module\Framework\PageHooks\Admin;

class CustomAdminPageHook extends AbstractAdminPageHook
{
    protected $templateName;

    public function setTemplate($template)
    {
        $this->templateName = $template;

        return $this;
    }
}
