<?php

namespace WHMCS\Module\Framework\ConfigBuilder;

abstract class AbstractConfigBuilder
{

    protected $settleKey = false;
    protected $config = [];

    public static function builder()
    {
        return new static();
    }

    public function __construct() { }

    public function hasSettleKey()
    {
        return !!$this->settleKey;
    }

    public function build()
    {
        $config = [];
        foreach ($this->config as $field => $value) {
            if (is_null($value)) {
                continue;
            }
            elseif (is_array($value) and $value) {
                foreach ($value as $i => $v) {
                    if ($v instanceof self) {
                        if (!$v->hasSettleKey()) {
                            $value[ $i ] = $v->build();
                        }
                        else {
                            unset($value[ $i ]);
                            $build = $v->build();
                            foreach ($build as $bf => $bv) {
                                $value[$bf] = $bv;
                            }
                        }
                    }
                }
            }

            $config[ $field ] = $value;
        }

        return $this->settleKey ? [$this->settleKey => $config] : $config;
    }

    public function set($configKey, $value)
    {
        $this->config[ $configKey ] = $value;

        return $this;
    }
}