<?php

namespace WHMCS\Module\Framework\PageHooks;

use ErrorException;
use WHMCS\Module\Framework\Events\CallbackHook;
use WHMCS\Module\Framework\Helper;

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
            if (empty($vars['templatefile'])) {
                throw new ErrorException("Bad hook \"$hook\" result, no \"templatefile\" variable is passed");
            }
            $page = $vars['templatefile'];

            // To Another page
            if ('*' != $templateName and $templateName != $page) {
                return '';
            }

            $return = call_user_func($codeGenerator, $vars);

            // Fix template if needed
            if ($return) {
                $self->fixTemplate($vars);
            }

            return $return;
        };
    }

    protected function fixTemplate(array $vars)
    {
        if (!empty($vars['templatefile'])) {
            $template = $vars['templatefile'];
        }
        else {
            return;
        }
        if (!empty($vars['template'])) {
            $theme = $vars['template'];
        }
        else {
            return;
        }

        $adjustements = [];
        switch ($template) {
            case 'viewinvoice':
                $adjustements = [
                    '{$headoutput}' => ['marker' => preg_quote('</head>'), 'position' => 'before'],
                    '{$headeroutput}' => ['marker' => preg_quote('<body>'), 'position' => 'after'],
                    '{$footeroutput}' => ['marker' => preg_quote('</body>'), 'position' => 'before'],
                ];
                break;
        }

        if (!$adjustements) {
            return;
        }

        $path = Helper::getRootDir() . "/templates/$theme/$template.tpl";
        $pathBackup = "$path.replacement-backup";
        if (!file_exists($path)) {
            return;
        }
        // No need to process more
        if (file_exists($pathBackup) and (filemtime($pathBackup) > filemtime($path))) {
            return;
        }

        $content = file_get_contents($path);
        foreach ($adjustements as $injection => $data) {
            // Is not in the template
            if (false === strpos($content, $injection)) {
                $content = preg_replace(
                    "~({$data['marker']})~",
                    'before' == $data['position'] ? "$injection\n$1" : "$1\n$injection",
                    $content,
                    1,
                    $replaced
                );

                if (!$replaced) {
                    throw new ErrorException("Cannot inject variable \"$injection\" into \"$template\"");
                }
            }
        }

        // Make backup
        if (file_exists($pathBackup)) {
            unlink($pathBackup);
        }
        copy($path, $pathBackup);
        file_put_contents($path, $content);
        touch($pathBackup);

        // Ok, we're done
    }
}
