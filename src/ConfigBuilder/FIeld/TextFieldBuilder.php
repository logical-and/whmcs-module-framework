<?php

namespace WHMCS\Module\Framework\ConfigBuilder\Field;

use WHMCS\Module\Framework\ConfigBuilder\FieldConfigBuilder;

class TextFieldBuilder extends FieldConfigBuilder
{

    const TYPE = 'text';

    public function __construct()
    {
        $this->config[ 'Type' ] = static::TYPE;

        parent::__construct();
    }
}
