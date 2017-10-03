<?php

namespace WHMCS\Module\Framework\ConfigBuilder\Field;

class DropdownFieldBuilder extends TextFieldBuilder
{

    const TYPE = 'dropdown';

    public function __construct()
    {
        $this->config[ 'Options' ] = [];

        parent::__construct();
    }

    public function addOption($text, $value = null)
    {
        if (!$value) {
            $value = $text;
        }

        $this->config[ 'Options' ][ $value ] = $text;

        return $this;
    }
}
