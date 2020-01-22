<?php

namespace WHMCS\Module\Framework;

use Axelarge\ArrayTools\Arr;
use WHMCS\Module\Framework\ConfigBuilder\AddonConfigBuilder;
use WHMCS\Module\Framework\Events\ModuleListeners\Addon\ActivateAddonListenerBuilder;
use WHMCS\Module\Framework\Events\ModuleListeners\Addon\UpgradeAddonListenerBuilder;

class Addon extends AbstractModule
{
    const TYPE = 'addon';
    const TYPE_DIRECTORY = 'modules/addons';

    /**
     * @return AddonConfigBuilder
     */
    public static function configBuilder()
    {
        return AddonConfigBuilder::builder();
    }

    /**
     * Called only once
     */
    protected function register()
    {
        $this->registerConfigFunction($this->getId() . '_config', $this->getOriginalConfig());
    }

    public function getConfig($key = null, $default = null)
    {
        if (!$this->config) {
            // Set original config values
            $config[ 'original' ] = $this->getOriginalConfig();
            if (!empty($config[ 'original' ][ 'fields' ])) {
                foreach ($config[ 'original' ][ 'fields' ] as $field => $data) {
                    if (isset($data[ 'Default' ])) {
                        $config[ $field ] = $data[ 'Default' ];
                    }
                }
            }

            $moduleName = $this->getId();
            foreach (Helper::connAssoc()->select("SELECT * FROM tbladdonmodules WHERE module = '$moduleName'") as $row) {
                $row                         = json_decode(json_encode($row), true);
                $config[ $row[ 'setting' ] ] = html_entity_decode($row[ 'value' ]);
            }

            $this->config = $config;
        }

        return !$key ? $this->config : Arr::getNested($this->config, $key, $default);
    }

    public function isEnabled()
    {
        return static::isModuleEnabled($this->getId());
    }

    public static function isModuleEnabled($id)
    {
        return self::getStaticCachedResult(static::TYPE . $id, function() use ($id) {
            $result = !!Helper::connAssoc()
                ->selectOne("SELECT count(*) as enabled FROM tbladdonmodules WHERE module = ?", [$id])['enabled'];

            return $result;
        });
    }

    public function onActivateListener(callable $listener)
    {
        return $this->registerModuleListeners([ActivateAddonListenerBuilder::build($listener)]);
    }

    public function onUpgradeListeners(array $versionsListeners)
    {
        $listener = UpgradeAddonListenerBuilder::build($versionsListeners);
        $this->registerModuleListeners([$listener]);

        // Subscribe to activation too
        $self = $this;
        $this->onActivateListener(function() use (&$listener, &$self) {

            $listener->callHandler([
                // Emulate arguments
                'version' => UpgradeAddonListenerBuilder::getAddonTrackedVersion($self) // kinda previous
            ]);
        });

        return $this;
    }
}