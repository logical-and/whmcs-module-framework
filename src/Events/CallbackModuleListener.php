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
        $this->callback = Closure::bind($callback, $this);

        return $this;
    }
    protected function execute(array $args = null)
    {
        $parameters = [$args];

        // Fix PHP 5.6 Closure::bind()
        if (PHP_MAJOR_VERSION < 7) {
            $parameters[] = $this;
        }

        return call_user_func_array($this->callback, $parameters);
    }
}
