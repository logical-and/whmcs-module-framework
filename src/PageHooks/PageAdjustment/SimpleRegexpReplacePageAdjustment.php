<?php

namespace WHMCS\Module\Framework\PageHooks\PageAdjustment;

use WHMCS\Module\Framework\PageHooks\AbstractPageAdjustment;

class SimpleRegexpReplacePageAdjustment extends AbstractPageAdjustment
{

    protected $content;
    protected $injection;
    protected $target;
    protected $position;

    /**
     * Set content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set injection
     *
     * @param string $injection
     * @return $this
     */
    public function setInjection($injection)
    {
        $this->injection = $injection;

        return $this;
    }

    /**
     * Get injection
     *
     * @return mixed
     */
    public function getInjection()
    {
        return $this->injection;
    }

    /**
     * Set target
     *
     * @param string $target
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    public function isAlreadyApplied()
    {
        $this->validateParameters();

        return false !== strpos($this->content, $this->injection);
    }

    public function apply()
    {
        $this->validateParameters();

        $content = preg_replace(
            "~({$this->target})~",
            self::POSITION_BEFORE == $this->position ? "{$this->injection}\n$1" : "$1\n{$this->injection}",
            $this->content,
            1,
            $replaced
        );

        return $replaced ? $content : false;
    }

    protected function validateParameters()
    {
        if (!$this->content) {
            throw new \BadMethodCallException('No content is defined');
        }

        if (!$this->injection) {
            throw new \BadMethodCallException('No injection is defined');
        }

        if (!$this->target) {
            throw new \BadMethodCallException('No target is defined');
        }

        if (!$this->position) {
            throw new \BadMethodCallException('No position is defined');
        }
        if (!in_array($this->position, [self::POSITION_BEFORE, self::POSITION_AFTER])) {
            throw new \BadMethodCallException("Position value \"{$this->position}\" is wrong");
        }
    }
}
