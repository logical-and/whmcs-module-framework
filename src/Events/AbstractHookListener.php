<?php

namespace WHMCS\Module\Framework\Events;

use ErrorException;

abstract class AbstractHookListener extends AbstractListener
{
    public function register()
    {
        if (!$this->registered) {
            if (!trim((string) $this->name)) {
                throw new ErrorException("Hook name is not defined");
            }

            /** @noinspection PhpUndefinedFunctionInspection */
            add_hook($this->name, $this->priority, function ($args) {
                return $this->execute($args ? $args : []);
            });

            $this->registered = true;
        }

        return $this;
    }
}
