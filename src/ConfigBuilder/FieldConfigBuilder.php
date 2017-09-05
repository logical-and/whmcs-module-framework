<?php

namespace WHMCS\Module\Framework\ConfigBuilder;

use WHMCS\Module\Framework\ConfigBuilder\Field\BoolFieldBuilder;
use WHMCS\Module\Framework\ConfigBuilder\Field\DropdownFieldBuilder;
use WHMCS\Module\Framework\ConfigBuilder\Field\PasswordFieldBuilder;
use WHMCS\Module\Framework\ConfigBuilder\Field\RadioFieldBuilder;
use WHMCS\Module\Framework\ConfigBuilder\Field\TextareaFieldBuilder;
use WHMCS\Module\Framework\ConfigBuilder\Field\TextFieldBuilder;

class FieldConfigBuilder extends AbstractConfigBuilder
{

    protected $config = [
        'FriendlyName' => null,
        'Type'         => 'text',
        'Size'         => null,
        'Description'  => null,
        'Default'      => null
    ];

    // Types shortcuts

    /**
     * @param $key
     * @param $friendlyName
     * @return BoolFieldBuilder
     */
    public static function bool($key, $friendlyName)
    {
        return (new BoolFieldBuilder())->setName($key)->setFriendlyName($friendlyName);
    }

    /**
     * @param $key
     * @param $friendlyName
     * @return DropdownFieldBuilder
     */
    public static function dropdown($key, $friendlyName)
    {
        return (new DropdownFieldBuilder())->setName($key)->setFriendlyName($friendlyName);
    }

    /**
     * @param $key
     * @param $friendlyName
     * @return PasswordFieldBuilder
     */
    public static function password($key, $friendlyName)
    {
        return (new PasswordFieldBuilder())->setName($key)->setFriendlyName($friendlyName);
    }

    /**
     * @param $key
     * @param $friendlyName
     * @return RadioFieldBuilder
     */
    public static function radio($key, $friendlyName)
    {
        return (new RadioFieldBuilder())->setName($key)->setFriendlyName($friendlyName);
    }

    /**
     * @param $key
     * @param $friendlyName
     * @return TextareaFieldBuilder
     */
    public static function textarea($key, $friendlyName)
    {
        return (new TextareaFieldBuilder())->setName($key)->setFriendlyName($friendlyName);
    }

    /**
     * @param $key
     * @param $friendlyName
     * @return TextFieldBuilder
     */
    public static function text($key, $friendlyName)
    {
        return (new TextFieldBuilder())->setName($key)->setFriendlyName($friendlyName);
    }

    // Handlers

    public function build()
    {
        if (!$this->settleKey) {
            $this->settleKey = uniqid('field');
        }

        return parent::build();
    }

    // Common accessors

    public function setName($value)
    {
        $this->settleKey = $value;

        return $this;
    }

    public function setFriendlyName($value)
    {
        $this->config[ 'FriendlyName' ] = $value;

        return $this;
    }

    public function setSize($value)
    {
        $this->config[ 'Size' ] = $value;

        return $this;
    }

    public function setDescription($value)
    {
        $this->config[ 'Description' ] = $value;

        return $this;
    }

    public function setDefaultValue($value)
    {
        $this->config[ 'Default' ] = $value;

        return $this;
    }
}
