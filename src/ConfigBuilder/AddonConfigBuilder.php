<?php

namespace WHMCS\Module\Framework\ConfigBuilder;

class AddonConfigBuilder extends AbstractConfigBuilder
{

    protected $config = [
        'name'        => null,
        'description' => null,
        'version'     => '1.0',
        'author'      => null,
        'fields'      => []
    ];

    public function setName($value)
    {
        $this->config[ 'name' ] = $value;

        return $this;
    }

    public function setDescription($value)
    {
        $this->config[ 'description' ] = $value;

        return $this;
    }

    public function setVersion($value)
    {
        $this->config[ 'version' ] = $value;

        return $this;
    }

    public function setAuthor($value)
    {
        $this->config[ 'author' ] = $value;

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
