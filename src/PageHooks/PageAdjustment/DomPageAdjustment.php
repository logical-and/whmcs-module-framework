<?php

namespace WHMCS\Module\Framework\PageHooks\PageAdjustment;

use WHMCS\Module\Framework\Helper;
use WHMCS\Module\Framework\PageHooks\AbstractPageAdjustment;

class DomPageAdjustment extends AbstractPageAdjustment
{
    protected $cssPath;
    protected $action = [];

    /**
     * Get cssPath
     *
     * @return mixed
     */
    public function getCssPath()
    {
        return $this->cssPath;
    }

    /**
     * Set cssPath
     *
     * @param mixed $cssPath
     * @return $this
     */
    public function setCssPath($cssPath)
    {
        $this->cssPath = $cssPath;

        return $this;
    }

    public function setActionAddAfter($node)
    {
        $this->action['type'] = 'add';
        $this->action['position'] = self::POSITION_AFTER;
        $this->action['node'] = $this->prepareHtml($node);

        return $this;
    }

    public function setActionAddBefore($node)
    {
        $this->action['type'] = 'add';
        $this->action['position'] = self::POSITION_BEFORE;
        $this->action['node'] = $this->prepareHtml($node);

        return $this;
    }

    public function setActionSetProperty($property, $value)
    {
        $this->action['type'] = 'prop';
        $this->action['prop'] = $property;
        $this->action['value'] = $value;

        return $this;
    }

    public function setActionReplaceNode($withNode)
    {
        $this->action['type'] = 'replace';
        $this->action['node'] = $this->prepareHtml($withNode);

        return $this;
    }

    public function setActionHideNode()
    {
        $this->setActionSetProperty('style', 'display: none');

        return $this;
    }

    public function apply()
    {
        $this->validateParameters();

        $templatesDir = __DIR__ . '/../../../templates/adjustments/dom';

        switch ($this->action['type']) {
            case 'add':
            case 'prop':
            case 'replace':
                $snippet = Helper::renderTemplate("$templatesDir/{$this->action['type']}.js",
                    array_merge(['path' => $this->cssPath], $this->action)
                );
                break;

            default:
                throw new \BadMethodCallException("Action type \"{$this->action['type']}\" is not defined");
        }

        return trim($snippet);
    }

    protected function prepareHtml($html)
    {
        return str_replace(["\r\n", "\n", "\r", PHP_EOL], "\\n", $html);
    }

    protected function validateParameters()
    {
        if (empty($this->action['type'])) {
            throw new \BadMethodCallException('No action is configured');
        }
    }
}
