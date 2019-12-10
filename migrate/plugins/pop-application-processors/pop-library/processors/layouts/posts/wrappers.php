<?php
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
class Wassup_Module_Processor_MultipleComponentLayoutWrappers extends PoP_Module_Processor_ConditionWrapperBase
{
    public const MODULE_MULTICOMPONENTWRAPPER_USERHIGHLIGHTPOSTINTERACTION = 'multicomponentwrapper-userhighlightpostinteraction';
    public const MODULE_MULTICOMPONENTWRAPPER_USERPOSTINTERACTION = 'multicomponentwrapper-userpostinteraction';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_MULTICOMPONENTWRAPPER_USERHIGHLIGHTPOSTINTERACTION],
            [self::class, self::MODULE_MULTICOMPONENTWRAPPER_USERPOSTINTERACTION],
        );
    }

    public function getConditionSucceededSubmodules(array $module)
    {
        $ret = parent::getConditionSucceededSubmodules($module);

        switch ($module[1]) {
            case self::MODULE_MULTICOMPONENTWRAPPER_USERHIGHLIGHTPOSTINTERACTION:
                $ret[] = [Wassup_Module_Processor_MultipleComponentLayouts::class, Wassup_Module_Processor_MultipleComponentLayouts::MODULE_MULTICOMPONENT_USERHIGHLIGHTPOSTINTERACTION];
                break;

            case self::MODULE_MULTICOMPONENTWRAPPER_USERPOSTINTERACTION:
                $ret[] = [Wassup_Module_Processor_MultipleComponentLayouts::class, Wassup_Module_Processor_MultipleComponentLayouts::MODULE_MULTICOMPONENT_USERPOSTINTERACTION];
                break;
        }

        return $ret;
    }

    public function getConditionField(array $module)
    {
        switch ($module[1]) {
            case self::MODULE_MULTICOMPONENTWRAPPER_USERHIGHLIGHTPOSTINTERACTION:
            case self::MODULE_MULTICOMPONENTWRAPPER_USERPOSTINTERACTION:
                return FieldQueryInterpreterFacade::getInstance()->getField('is-status', ['status' => POP_POSTSTATUS_PUBLISHED], 'published');
        }

        return null;
    }
}



