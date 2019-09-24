<?php

namespace WHMCS\Module\Framework\PageHooks;

use WHMCS\Module\Framework\Events\AbstractHookListener;
use WHMCS\Module\Framework\PageHooks\Admin\AbstractAdminPageHook;
use WHMCS\Module\Framework\PageHooks\Admin\CustomAdminPageHook;
use WHMCS\Module\Framework\PageHooks\Client\AbstractClientPageHook;
use WHMCS\Module\Framework\PageHooks\Client\CustomClientPageHook;

abstract class AbstractPageHookFacadeListener extends AbstractHookListener
{
    // Parameters to define
    protected $pageHookClass;
    protected $template;
    protected $position;
    protected $priority = 0;
    protected $ensureJquery = false;

    protected function getPageHookClass()
    {
        if (!$this->pageHookClass) {
            throw new \ErrorException('Page hook class is not defined');
        }

        return $this->pageHookClass;
    }

    protected function getPageHookInstance()
    {
        $class = $this->getPageHookClass();
        if (!is_subclass_of($class, AbstractPageHook::class)) {
            throw new \ErrorException(sprintf('Class "%s" should be inherited from "%s" class',
                $class, AbstractPageHook::class));
        }
        /** @var AbstractPageHook|CustomAdminPageHook|CustomAdminPageHook $class */
        $instance = $class::buildInstance();

        $classClient = CustomClientPageHook::class;
        $classAdmin = CustomAdminPageHook::class;
        if ($instance instanceof $classClient or $instance instanceof $classAdmin) {
            if ($this->template) {
                $instance->setTemplate($this->template);
            }
            else {
                throw new \RuntimeException('"template" parameter must be defined');
            }
        }

        return $instance;
    }

    protected function ensureJquery()
    {
        $this->ensureJquery = true;

        return $this;
    }

    public function register()
    {
        if (!$this->registered) {
            $instance = $this->getPageHookInstance();

            // Set parameters

            if (!$this->position) {
                throw new \ErrorException('Position must be defined');
            }
            $instance->setPosition($this->position);

            if ($this->priority) {
                $instance->setPriority($this->priority);
            }

            $callback = function(array $vars) {
                try {
                    // Break the chain
                    if (false === $this->preExecute()) {
                        /** @noinspection PhpInconsistentReturnPointsInspection */
                        return;
                    }

                    /** @noinspection PhpMethodParametersCountMismatchInspection */
                    return $this->execute($vars);
                }
                catch (\Exception $e) {
                    /** @noinspection PhpVoidFunctionResultUsedInspection */
                    $return = $this->onExecuteException($e);

                    if (!is_null($return)) {
                        return $return;
                    }
                    else {
                        throw $e;
                    }
                }
            };

            // Create a scope to protect "this" variable
            $callback->bindTo($this);
            $instance->setCodeCallback(function() use (&$callback) {
                return call_user_func_array($callback, func_get_args());
            });

            // Delegate subscribing
            $instance->apply();

            // Load jQuery when necessary
            if ($this->ensureJquery) {
                $instance->ensureJquery();
            }

            $this->registered = true;
        }
    }
}