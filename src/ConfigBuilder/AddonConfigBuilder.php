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

    public function setVersion($value, $stability = null)
    {
        if ($stability) {
            $template = '{version} <sup style="color: {color}">{stability}</sup>';
            $replacements = ['version' => $value, 'stability' => $stability];

            switch ($stability) {
                case 'dev':
                    $replacements['color'] = '#999';
                    break;

                case 'alpha':
                    $replacements['color'] = '#f79a22';
                    break;

                case 'beta':
                    $replacements['color'] = '#ffb710';
                    break;

                case 'RC':
                case 'stable':
                    $replacements['color'] = '#46a546';
                    break;

                default:
                    $replacements['color'] = '#666';
                    break;
            }

            if (!empty($replacements['color'])) {
                $value = str_replace(
                    array_map(function($v) { return '{' . $v . '}'; }, array_keys($replacements)),
                    array_values($replacements),
                    $template
                );
            }
        }

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
