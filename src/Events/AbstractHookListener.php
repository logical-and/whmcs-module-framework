<?php

namespace WHMCS\Module\Framework\Events;

use ErrorException;

abstract class AbstractHookListener
{
    protected $hookName;

    protected $priority = 0;

    protected $registered = false;

    public static function build()
    {
        return new static();
    }

    abstract protected function execute(array $args);

    /**
     * Get hookName
     *
     * @return string
     */
    public function getHookName()
    {
        return $this->hookName;
    }

    /**
     * Set hookName
     *
     * @param string $hookName
     * @return $this
     * @throws ErrorException
     */
    public function setHookName($hookName)
    {
        if (!empty(trim((string) $hookName))) {
            throw new ErrorException('Hook name cannot be empty!');
        }
        $this->hookName = $hookName;

        return $this;
    }

    /**
     * Get priority
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set priority
     *
     * @param int $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    public function register()
    {
        if (!$this->registered) {
            if (!trim((string) $this->hookName)) {
                throw new ErrorException("Hook name is not defined");
            }

            /** @noinspection PhpUndefinedFunctionInspection */
            add_hook($this->hookName, $this->priority, function ($args) {
                return $this->execute($args ? $args : []);
            });

            $this->registered = true;
        }

        return $this;
    }

    public function callHandler(array $args)
    {
        return $this->execute($args);
    }
}
