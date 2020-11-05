<?php
use PoP\ComponentModel\ModuleProcessors\AbstractDataloadModuleProcessor;
class PoP_SystemWP_WP_Module_Processor_SystemActions extends AbstractDataloadModuleProcessor
{
    public const MODULE_DATALOADACTION_SYSTEM_ACTIVATEPLUGINS = 'dataloadaction-system-activateplugins';

    // use PoP_SystemWP_WP_Module_Processor_SystemActionsTrait;
    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOADACTION_SYSTEM_ACTIVATEPLUGINS],
        );
    }

    public function executeAction(array $module, array &$props)
    {

        // The actionexecution is triggered directly
        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_SYSTEM_ACTIVATEPLUGINS:
                return true;
        }

        return parent::executeAction($module, $props);
    }

    public function getComponentMutationResolverBridgeClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_SYSTEM_ACTIVATEPLUGINS:
                return GD_DataLoad_ActionExecuter_SystemActivatePlugins::class;
        }

        return parent::getComponentMutationResolverBridgeClass($module);
    }
}



