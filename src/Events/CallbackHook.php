<?php

namespace WHMCS\Module\Framework\Events;

class CallbackHook extends AbstractHookListener
{

    protected $callback;

    public static function attachCallback($name, $priority, callable $callback)
    {
        $instance = new static();
        $instance->setName($name);
        $instance->setCallback($callback);

        if ($priority) {
            $instance->setPriority($priority);
        }

        return $instance->register();
    }

    public function setCallback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    protected function execute(array $args = null)
    {
        return call_user_func($this->callback, $args);
    }
}