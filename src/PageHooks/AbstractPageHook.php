<?php

namespace WHMCS\Module\Framework\PageHooks;

use ErrorException;
use WHMCS\Module\Framework\Events\CallbackHook;

abstract class AbstractPageHook
{
    const POSITION_HEAD_BOTTOM = 'head_botton';
    const POSITION_BODY_TOP = 'body_top';
    const POSITION_BODY_BOTTOM = 'body_bottom';

    // Defined by class
    protected $templateName;
    // Defined by parameters
    protected $position;
    protected $priority = 0;
    protected $codeGenerator;

    // --- Builder

    public static function buildInstance()
    {
        return new static();
    }

    public function setPosition($position)
    {
        if (!in_array($position, [
            static::POSITION_HEAD_BOTTOM, self::POSITION_BODY_TOP, static::POSITION_BODY_BOTTOM])) {
            throw new ErrorException("Position \"$position\" is invalid");
        }

        $this->position = $position;

        return $this;
    }

    public function setPriority($priority)
    {
        $this->priority = (int) $priority;

        return $this;
    }

    public function setCode($code)
    {
        $this->codeGenerator = function() use ($code) { return $code; };

        return $this;
    }

    public function setCodeCallback(callable $callback)
    {
        $this->codeGenerator = $callback;

        return $this;
    }

    public function apply()
    {
        $this->convertToCallbackHook()->register();
    }

    public function convertToCallbackHook()
    {
        $hook = $this->getHookForPosition($this->position);
        if (!$hook) {
            throw new ErrorException("Position \"$this->position\" is invalid");
        }

        if (!$this->codeGenerator) {
            throw new ErrorException("No code generator is defined");
        }

        $callbackHook = CallbackHook::getInstance()
            ->setName($hook)
            ->setPriority($this->priority);
        $callback = $this->getExecutorCallback($hook, $this->templateName, $this->codeGenerator);
        $callback = $callback->bindTo($callbackHook);
        $callbackHook->setCallback($callback);

        return $callbackHook;
    }

    // --- Methods to inherit

    abstract protected function getHookForPosition($position);

    // --- Processors

    protected function getExecutorCallback($hook, $templateName, callable $codeGenerator)
    {
        return function(array $vars) use ($templateName, $hook, $codeGenerator) {
            if (empty($vars['templatefile'])) {
                throw new ErrorException("Bad hook \"$hook\" result, no \"templatefile\" variable is passed");
            }
            $page = $vars['templatefile'];

            // To Another page
            if ('*' != $templateName and $templateName != $page) {
                return '';
            }

            return call_user_func($codeGenerator, $vars);
        };
    }
}
