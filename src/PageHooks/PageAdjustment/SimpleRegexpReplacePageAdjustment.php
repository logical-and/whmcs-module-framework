<?php

namespace WHMCS\Module\Framework\PageHooks\PageAdjustment;

use WHMCS\Module\Framework\PageHooks\AbstractPageAdjustment;

class SimpleRegexpReplacePageAdjustment extends AbstractPageAdjustment
{

    protected $content;
    protected $isReplace;
    protected $adjustment;
    protected $target;
    protected $position = self::POSITION_BEFORE;

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
        $this->isReplace = false;
        $this->adjustment = $injection;

        return $this;
    }

    /**
     * Set replacement
     *
     * @param string $replacement
     * @return $this
     */
    public function setReplacement($replacement)
    {
        $this->isReplace = true;
        $this->adjustment = $replacement;

        return $this;
    }

    /**
     * Get adjustment (injection or replacement)
     *
     * @return mixed
     */
    public function getAdjustment()
    {
        return $this->adjustment;
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

        return false !== strpos($this->content, $this->adjustment);
    }

    public function apply()
    {
        $this->validateParameters();

        if($this->isReplace) {
            $b = '';
        }
        else {
            $b = "\n\$1";
        }

        $content = preg_replace(
            "~({$this->target})~",
            self::POSITION_BEFORE == $this->position ? "{$this->adjustment}$b" : "$b{$this->adjustment}",
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

        if (!$this->adjustment) {
            throw new \BadMethodCallException('No adjustment is defined');
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
