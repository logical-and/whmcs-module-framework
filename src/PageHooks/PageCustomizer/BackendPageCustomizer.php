<?php

namespace WHMCS\Module\Framework\PageHooks\PageCustomizer;

use WHMCS\Module\Framework\PageHooks\AbstractPageAdjustment;
use WHMCS\Module\Framework\PageHooks\AbstractPageCustomizer;
use WHMCS\Module\Framework\PageHooks\PageAdjustment\SimpleRegexpReplacePageAdjustment;

class BackendPageCustomizer extends AbstractPageCustomizer
{
    protected $path;
    protected $allowedCustomizations = [SimpleRegexpReplacePageAdjustment::class];

    public function setPath($path)
    {
        if (!is_file($path)) {
            throw new \BadMethodCallException("Template \"$path\" is not a real file");
        }

        $this->path = $path;

        return $this;
    }

    public function apply()
    {
        $isChanged = false;

        if (!$this->adjustments) {
            return $isChanged;
        }

        if (!$this->path) {
            throw new \BadMethodCallException('Template is not defined');
        }

        $pathBackup = "{$this->path}.replacement-backup";
        // No need to process once more if backup file is exist and template
        if (file_exists($pathBackup) and (filemtime($pathBackup) >= filemtime($this->path))) {
            return $isChanged;
        }

        $content = file_get_contents($this->path);
        foreach ($this->adjustments as $adjustment) {
            /** @var AbstractPageAdjustment|SimpleRegexpReplacePageAdjustment $adjustment */
            $adjustment->setContent($content);
            if (!$adjustment->isAlreadyApplied()) {
                $result = $adjustment->apply();

                // Can be applied
                if (false !== $result) {
                    $content = $result;
                    $isChanged = true;
                }
                else {
                    throw new \RuntimeException('Cannot apply injection "' . $adjustment->getInjection() . '" ' .
                        'into "' . $this->path . '"');
                }
            }
        }

        // Make backup
        if ($isChanged) {
            if (!file_exists($pathBackup)) {
                copy($this->path, $pathBackup);
            }

            // Update file
            file_put_contents($this->path, $content);
            touch($this->path);
        }

        // Mark backup as updated to not check twice
        if (is_file($pathBackup)) {
            touch($pathBackup);
        }

        return $isChanged;
    }
}
