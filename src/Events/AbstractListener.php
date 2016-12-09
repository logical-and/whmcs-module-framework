<?php

namespace WHMCS\Module\Framework\Events;

use ErrorException;

abstract class AbstractListener
{
    protected $event;

    protected $priority = 0;

    protected $registered = false;

    public static function build()
    {
        return new static();
    }

    abstract protected function execute(array $args);

    abstract public function register();

    /**
     * Get event
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set event

     *
*@param string $event
     * @return $this
     * @throws ErrorException
     */
    public function setEvent($event)
    {
        if (!empty(trim((string) $event))) {
            throw new ErrorException('Hook name cannot be empty!');
        }
        $this->event = $event;

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

    public function callHandler(array $args)
    {
        return $this->execute($args);
    }
}
