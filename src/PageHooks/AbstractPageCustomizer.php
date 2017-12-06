<?php

namespace WHMCS\Module\Framework\PageHooks;

abstract class AbstractPageCustomizer
{
    /** @var AbstractPageAdjustment[] */
    protected $adjustments = [];

    protected $allowedCustomizations = [];

    public function add(AbstractPageAdjustment $adjustment)
    {
        if (!$this->isCustomizationAllowed($adjustment)) {
            throw new \BadMethodCallException('Page customization "' . get_class($adjustment) . '" is not allowed ' .
                'in "' . get_class($this) . '"');
        }

        $this->adjustments[] = $adjustment;

        return $this;
    }

    public function clean()
    {
        $this->adjustments = [];

        return $this;
    }

    public function hasAdjustments()
    {
        return !!$this->adjustments;
    }

    abstract public function apply();

    // --- Validation

    /**
     * Get list of allowed classes. Empty array means allowed
     *
     * @return string[]
     */
    protected function getAllowedCustomizations()
    {
        return $this->allowedCustomizations;
    }

    /**
     * Validates if customization can be applied
     * @param AbstractPageAdjustment $customization

     * @return bool
     */
    protected function isCustomizationAllowed(AbstractPageAdjustment $customization)
    {
        $whitelist = $this->getAllowedCustomizations();

        return !$whitelist or in_array(get_class($customization), $whitelist);
    }
}
