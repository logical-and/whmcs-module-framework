<?php

namespace WHMCS\Module\Framework\PageHooks;

abstract class AbstractPageAdjustment
{
    const POSITION_BEFORE = 'before';
    const POSITION_AFTER = 'after';

    public static function build()
    {
        return new static();
    }

    public function isAlreadyApplied()
    {
        $this->validateParameters();

        return false;
    }

    public function apply()
    {
        $this->validateParameters();

        return false;
    }

    protected function validateParameters()
    {

    }
}
