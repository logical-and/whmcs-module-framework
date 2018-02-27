<?php

namespace WHMCS\Module\Framework\PageHooks;

use ErrorException;
use WHMCS\Module\Framework\Events\CallbackHook;
use WHMCS\Module\Framework\Helper;
use WHMCS\Module\Framework\PageHooks\PageAdjustment\SimpleRegexpReplacePageAdjustment;
use WHMCS\Module\Framework\PageHooks\PageCustomizer\BackendPageCustomizer;
use WHMCS\Module\Framework\PageHooks\PageCustomizer\JsPageCustomizer;

abstract class AbstractPageHook
{
    const POSITION_HEAD_BOTTOM = 'head_bottom';
    const POSITION_BODY_TOP = 'body_top';
    const POSITION_BODY_BOTTOM = 'body_bottom';

    // Defined by class
    protected $templateName;
    // Defined by parameters
    protected $position;
    protected $priority = 0;
    protected $codeGenerator;

    /**
     * @var BackendPageCustomizer[]
     */
    protected $backendCustomizers = [];
    /**
     * @var JsPageCustomizer[]
     */
    protected $jsCustomizers = [];

    // --- Builder

    public static function buildInstance()
    {
        return new static();
    }

    public function __construct()
    {
        $this->backendCustomizers[] = new BackendPageCustomizer();
        $this->jsCustomizers[] = new JsPageCustomizer();
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

    public function addBackendPageAdjustment(AbstractPageAdjustment $adjustment)
    {
        $this->backendCustomizers[0]->add($adjustment);

        return $this;
    }

    public function addJsPageAdjustment(AbstractPageAdjustment $adjustment)
    {
        $this->position = self::POSITION_BODY_BOTTOM;
        $this->jsCustomizers[0]->add($adjustment);

        return $this;
    }

    public function apply()
    {
        $callback = $this->convertToCallbackHook();
        if (false !== $callback->preRegister()) {
            $callback->register();
        }
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

        $callbackHook = CallbackHook::createCallback($hook, $this->priority, function() {});
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
        $self = $this;
        return function(array $vars) use ($templateName, $hook, $codeGenerator, $self) {
            // Client area
            if (!empty($vars['templatefile'])) {
                $page = $vars['templatefile'];
            }
            // Admin area
            elseif (!empty($vars['filename'])) {
                $page = $vars['filename'];
            }
            else {
                throw new ErrorException("Bad hook \"{$hook}\" result, no \"templatefile\" or \"filename\" variable is passed");
            }

            // To another page
            if ('*' != $templateName and strtolower($templateName) != strtolower($page)) {
                return '';
            }

            // Fix templates
            switch ($page) {
                case 'viewinvoice':
                case 'oauth/layout':
                    if (!empty($vars['template'])) {
                        $theme = $vars['template'];
                        $path = Helper::getRootDir() . "/templates/$theme/$page.tpl";

                        if (is_file($path)) {
                            $customizer = new BackendPageCustomizer();
                            $customizer->setPath($path);
                            $self->backendCustomizers[] = $customizer;

                            $customizer->add(SimpleRegexpReplacePageAdjustment::build()
                                ->setTarget(preg_quote('</head>'))
                                ->setInjection('{$headoutput}')
                                ->setPosition(SimpleRegexpReplacePageAdjustment::POSITION_BEFORE));
                            $customizer->add(SimpleRegexpReplacePageAdjustment::build()
                                ->setTarget(preg_quote('<body>'))
                                ->setInjection('{$headeroutput}')
                                ->setPosition(SimpleRegexpReplacePageAdjustment::POSITION_AFTER));
                            $customizer->add(SimpleRegexpReplacePageAdjustment::build()
                                ->setTarget(preg_quote('</body>'))
                                ->setInjection('{$footeroutput}')
                                ->setPosition(SimpleRegexpReplacePageAdjustment::POSITION_BEFORE));
                        }
                    }

                    break;
            }

            $codeGenerator = $codeGenerator->bindTo($self);
            
            $return = call_user_func($codeGenerator, $vars);

            if ($self->jsCustomizers[0]->hasAdjustments() and self::POSITION_BODY_BOTTOM != $self->position) {
                throw new \RuntimeException('Position must be POSITION_BODY_BOTTOM when js customizer is used');
            }

            foreach ($self->jsCustomizers as $customizer) {
                $result = $customizer->apply();
                if ($result) {
                    if ($return) {
                        $return .= $result;
                    }
                    else {
                        $return = $result;
                    }
                }

            }

            // Fix templates if needed
            if ($return) {
                foreach ($self->backendCustomizers as $customizer) {
                    $customizer->apply();
                }
            }

            return $return;
        };
    }
}
