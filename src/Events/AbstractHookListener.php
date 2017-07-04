<?php

namespace WHMCS\Module\Framework\Events;

use ErrorException;
use RuntimeException;
use WHMCS\Module\Framework\AbstractModule;

abstract class AbstractHookListener extends AbstractListener
{
    protected $moduleFile;
    /** @var AbstractModule */
    protected $module;

    public function register()
    {
        if (!$this->registered) {
            if (!trim((string) $this->name)) {
                throw new ErrorException("Hook name is not defined");
            }

            /** @noinspection PhpUndefinedFunctionInspection */
            add_hook($this->name, $this->priority, function ($args) {
                try {
                    // Break the chain
                    if (false === $this->preExecute()) {
                        /** @noinspection PhpInconsistentReturnPointsInspection */
                        return;
                    }

                    return $this->execute($args ? $args : []);
                }
                catch (\Exception $e) {
                    /** @noinspection PhpVoidFunctionResultUsedInspection */
                    $return = $this->onExecuteException($e);

                    if (!is_null($return)) {
                        return $return;
                    }
                    else {
                        throw $e;
                    }
                }
            });

            $this->registered = true;
        }

        return $this;
    }

    public function defineHooksFile($file)
    {
        if (!is_file($file)) {
            throw new ErrorException("\"$file\" is not a file!");
        }

        if ('hooks' != pathinfo($file, PATHINFO_FILENAME)) {
            throw new ErrorException("\"$file\" is not a hooks file!");
        }

        $moduleDir = dirname($file);
        $moduleName = pathinfo($moduleDir, PATHINFO_FILENAME);
        $moduleFile = "$moduleDir/$moduleName.php";

        if (!is_file($moduleFile)) {
            throw new ErrorException("\"$moduleFile\" is not a module file!");
        }

        $this->moduleFile = $moduleFile;
    }

    /**
     * @return AbstractModule
     */
    public function getModule()
    {
        if ($this->module) {
            return $this->module;
        }

        if (!$this->moduleFile) {
            throw new RuntimeException('Module file has not been defined');
        }

        require_once $this->moduleFile;
        return $this->module = AbstractModule::getInstanceByFile($this->moduleFile);
    }
}
