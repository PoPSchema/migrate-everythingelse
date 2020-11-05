<?php
use PoP\ComponentModel\ModuleProcessors\AbstractDataloadModuleProcessor;
class PoP_System_Module_Processor_SystemActions extends AbstractDataloadModuleProcessor
{
    public const MODULE_DATALOADACTION_SYSTEM_BUILD = 'dataloadaction-system-build';
    public const MODULE_DATALOADACTION_SYSTEM_GENERATE = 'dataloadaction-system-generate';
    public const MODULE_DATALOADACTION_SYSTEM_INSTALL = 'dataloadaction-system-install';

    // use PoP_System_Module_Processor_SystemActionsTrait;
    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOADACTION_SYSTEM_BUILD],
            [self::class, self::MODULE_DATALOADACTION_SYSTEM_GENERATE],
            [self::class, self::MODULE_DATALOADACTION_SYSTEM_INSTALL],
        );
    }

    public function executeAction(array $module, array &$props)
    {

        // The actionexecution is triggered directly
        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_SYSTEM_BUILD:
            case self::MODULE_DATALOADACTION_SYSTEM_GENERATE:
            case self::MODULE_DATALOADACTION_SYSTEM_INSTALL:
                return true;
        }

        return parent::executeAction($module, $props);
    }

    public function getComponentMutationResolverBridgeClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_SYSTEM_BUILD:
                return GD_DataLoad_ActionExecuter_SystemBuild::class;

            case self::MODULE_DATALOADACTION_SYSTEM_GENERATE:
                return GD_DataLoad_ActionExecuter_SystemGenerate::class;

            case self::MODULE_DATALOADACTION_SYSTEM_INSTALL:
                return GD_DataLoad_ActionExecuter_SystemInstall::class;
        }

        return parent::getComponentMutationResolverBridgeClass($module);
    }
}



