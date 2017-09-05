<?php

namespace WHMCS\Module\Framework\ConfigBuilder;

class ServerConfigBuilder extends AbstractConfigBuilder
{

    protected $config = [
        'DisplayName'              => null,
        'APIVersion'               => '1.0',
        'RequiresServer'           => null,
        'DefaultNonSSLPort'        => null,
        'DefaultSSLPort'           => null,
        'ServiceSingleSignOnLabel' => null,
        'AdminSingleSignOnLabel'   => null,
        'fields'                   => []
    ];

    public function setName($value)
    {
        $this->config[ 'DisplayName' ] = $value;

        return $this;
    }

    public function setApiVersion($value)
    {
        $this->config[ 'APIVersion' ] = $value;

        return $this;
    }

    public function isRequiresServer($value)
    {
        $this->config[ 'RequiresServer' ] = !!$value;

        return $this;
    }

    public function setDefaultNonSslPort($value)
    {
        $this->config[ 'DefaultNonSSLPort' ] = $value;

        return $this;
    }

    public function setDefaultSslPort($value)
    {
        $this->config[ 'DefaultSSLPort' ] = $value;

        return $this;
    }

    public function setServiceSingleSignOnLavel($value)
    {
        $this->config[ 'ServiceSingleSignOnLabel' ] = $value;

        return $this;
    }

    public function setAdminSingleSignOnLabel($value)
    {
        $this->config[ 'AdminSingleSignOnLabel' ] = $value;

        return $this;
    }

    public function addFields(array $fields)
    {
        foreach ($fields as $field) {
            $this->addField($field);
        }

        return $this;
    }

    public function addField(FieldConfigBuilder $field)
    {
        $this->config[ 'fields' ][] = $field;

        return $this;
    }

    public function clearFields()
    {
        $this->config[ 'fields' ] = [];

        return $this;
    }
}
