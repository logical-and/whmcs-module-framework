<?php

namespace WHMCS\Module\Framework\ConfigBuilder\Field;

class PasswordFieldBuilder extends TextFieldBuilder
{

    const TYPE = 'password';

    public function __construct()
    {
        $this->config[ 'FriendlyName' ] = 'Password';
        parent::__construct();
    }
}
