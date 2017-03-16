<?php

namespace WHMCS\Module\Framework\Events;

use ErrorException;
use WHMCS\Module\Framework\AbstractModule;

abstract class AbstractModuleListener extends AbstractListener
{
    public static $shared = [];

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

            // Wrapper
            $fn = function ($args) {
                // Break the chain
                if (false === call_user_func_array([$this, 'preExecute'], $args)) {
                    return true;
                }

                return call_user_func_array([$this, 'execute'], $args);
            };
            // Proper context
            $fn->bind($fn, $this);
            self::$shared[$fnName][] = $fn;

            $this->registered = true;

            // Define main hook function at once
            if (!function_exists($fnName)) {
                // Attach to function body
                eval(sprintf(
                    'function %s() { 
                        $id = "%s";
                        $class = "%s";
                        if (!empty($class::$shared[$id])) {
                            foreach ($class::$shared[$id] as $cb) {
                                $cb(func_get_args());
                            }
                        }
                     }',
                    $fnName, $fnName, self::class
                ));
            }
        }
    }
}
