<?php
use PoP\ComponentModel\ModuleProcessors\AbstractDataloadModuleProcessor;
class PoP_System_Theme_Module_Processor_SystemActions extends AbstractDataloadModuleProcessor
{
    public const MODULE_DATALOADACTION_SYSTEM_GENERATETHEME = 'dataloadaction-system-generate-theme';

    // use PoP_System_Theme_Module_Processor_SystemActionsTrait;
    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOADACTION_SYSTEM_GENERATETHEME],
        );
    }

    public function executeAction(array $module, array &$props)
    {

        // The actionexecution is triggered directly
        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_SYSTEM_GENERATETHEME:
                return true;
        }

        return parent::executeAction($module, $props);
    }

    public function getComponentMutationResolverBridgeClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_SYSTEM_GENERATETHEME:
                return GD_DataLoad_ActionExecuter_SystemGenerateTheme::class;
        }

        return parent::getComponentMutationResolverBridgeClass($module);
    }
}



