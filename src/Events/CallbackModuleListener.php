<?php

namespace WHMCS\Module\Framework\Events;

use Closure;

class CallbackModuleListener extends AbstractModuleListener
{
    protected $callback;

    public static function createCallback($name, callable $callback)
    {
        $instance = new static();
        $instance->setName($name);
        $instance->setCallback($callback);

        return $instance;
    }

    public static function attachCallback($name, callable $callback)
    {
        $instance = new static();
        $instance->setName($name);
        $instance->setCallback($callback);

        if (false !== $instance->preRegister()) {
            $instance->register();
        }
    }

    public function setCallback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    protected function execute(array $args = null)
    {
        // Change the scope
        if ($this->callback instanceof Closure) {
            $this->callback = $this->callback->bindTo($this);
        }

        return call_user_func($this->callback, $args);
    }
}
