<?php

namespace WHMCS\Module\Framework\Events;

class CallbackHook extends AbstractHookListener
{

    protected $callback;

    public static function attachCallback($name, $priority, callable $callback)
    {
        $instance = new static();
        $instance->setHookName($name);
        $instance->setCallback($callback);

        if ($priority) {
            $instance->setPriority($priority);
        }

        return $instance->register();
    }

    public function setCallback(callable $callback)
    {

    }

    protected function execute(array $args)
    {
        return call_user_func($this->callback, $args);
    }
}
