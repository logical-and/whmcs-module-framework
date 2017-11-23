<?php

namespace WHMCS\Module\Framework\PageHooks;

use WHMCS\Module\Framework\Events\AbstractHookListener;

abstract class AbstractPageHookFacadeListener extends AbstractHookListener
{
    // Parameters to define
    protected $pageHookClass;
    protected $position;
    protected $priority = 0;

    protected function getPageHookClass()
    {
        if (!$this->pageHookClass) {
            throw new \ErrorException('Page hook class is not defined');
        }

        return $this->pageHookClass;
    }

    public function register()
    {
        if (!$this->registered) {
            $class = $this->getPageHookClass();
            if (!is_subclass_of($class, AbstractPageHook::class)) {
                throw new \ErrorException(sprintf('Class "%s" should be inherited from "%s" class',
                    $class, AbstractPageHook::class));
            }
            /** @var AbstractPageHook $class */
            $instance = $class::buildInstance();

            // Set parameters

            if (!$this->position) {
                throw new \ErrorException('Position must be defined');
            }
            $instance->setPosition($this->position);

            if ($this->priority) {
                $instance->setPriority($this->priority);
            }
            $instance->setCodeCallback(function(array $vars) {
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
            });

            // Delegate subscribing
            $instance->apply();

            $this->registered = true;
        }
    }
}