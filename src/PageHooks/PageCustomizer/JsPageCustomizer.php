<?php

namespace WHMCS\Module\Framework\PageHooks\PageCustomizer;

use WHMCS\Module\Framework\Helper;
use WHMCS\Module\Framework\PageHooks\AbstractPageCustomizer;
use WHMCS\Module\Framework\PageHooks\PageAdjustment\DomPageAdjustment;

class JsPageCustomizer extends AbstractPageCustomizer
{
    protected $allowedCustomizations = [DomPageAdjustment::class];

    public function apply()
    {
        $snippet = '';

        foreach ($this->adjustments as $adjustment) {
            /** @var DomPageAdjustment $adjustment */
            $result = $adjustment->apply();

            if ($result) {
                $snippet .= $result . PHP_EOL;
            }
        }

        $snippet = trim($snippet);

        if ($snippet) {
            $isSSl = !empty($_SERVER['HTTPS']) and $_SERVER['HTTPS'] != 'off';
            $snippet = Helper::renderTemplate(__DIR__ . '/../../../templates/adjustments/layout.tpl', [
                'jQueryScript' => Helper::getConfigValue($isSSl ? 'SystemSSLURL' : 'SystemURL') . 'assets/js/jquery.min.js',
                'code' => $snippet,
            ]);
        }

        return $snippet ? $snippet : false;
    }
}
