<?php
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
class UserStance_Module_Processor_ButtonWrappers extends PoP_Module_Processor_ConditionWrapperBase
{
    public const MODULE_BUTTONWRAPPER_STANCEVIEW = 'buttonwrapper-stanceview';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_BUTTONWRAPPER_STANCEVIEW],
        );
    }

    public function getConditionSucceededSubmodules(array $module)
    {
        $ret = parent::getConditionSucceededSubmodules($module);

        switch ($module[1]) {
            case self::MODULE_BUTTONWRAPPER_STANCEVIEW:
                $ret[] = [UserStance_Module_Processor_Buttons::class, UserStance_Module_Processor_Buttons::MODULE_BUTTON_STANCEVIEW];
                break;
        }

        return $ret;
    }

    public function getConditionField(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_BUTTONWRAPPER_STANCEVIEW:
                return FieldQueryInterpreterFacade::getInstance()->getField('is-status', ['status' => POP_POSTSTATUS_PUBLISHED], 'published');
        }

        return null;
    }
}



