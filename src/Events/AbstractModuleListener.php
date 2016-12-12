<?php

namespace WHMCS\Module\Framework\Events;

use ErrorException;
use WHMCS\Module\Framework\AbstractModule;

abstract class AbstractModuleListener extends AbstractListener
{
    /** @var AbstractModule */
    protected $module;

    public function setModule(AbstractModule $module)
    {
        $this->module = $module;

        return $this;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function register()
    {
        if (!$this->registered) {
            if (!trim((string) $this->name)) {
                throw new ErrorException("Hook name is not defined");
            }

            if (!$this->module) {
                throw new ErrorException("Module is not defined");
            }

            $fnName = $this->module->getId() . '_' . $this->name;

            if (!function_exists($fnName)) {
                // Wrapper
                $fn = function ($args) {
                    return call_user_func_array([$this, 'execute'], $args);
                };
                // Proper context
                $fn->bind($fn, $this);

                // Share variable by REQUEST global variable
                $uid = '$' . uniqid('', true);
                $_REQUEST[$uid] = $fn;

                // Attach to function body
                eval(sprintf(
                    'function %s() { return $_REQUEST["%s"](func_get_args()); }',
                    $this->module->getId() . '_' . $this->name, $uid
                ));

                $this->registered = true;
            }
        }
    }
}
