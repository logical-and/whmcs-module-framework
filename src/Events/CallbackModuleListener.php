<?php

namespace WHMCS\Module\Framework\Events;

class CallbackModuleListener extends AbstractModuleListener
{
    protected $callback;

    public static function attachCallback($name, callable $callback)
    {
        $instance = new static();
        $instance->setEvent($name);
        $instance->setCallback($callback);

        return $instance->register();
    }

    public function setCallback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    protected function execute(array $args)
    {
        return call_user_func($this->callback, $args);
    }
}
