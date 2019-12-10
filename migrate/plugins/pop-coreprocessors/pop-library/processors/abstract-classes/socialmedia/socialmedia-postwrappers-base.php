<?php
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
abstract class PoP_Module_Processor_SocialMediaPostWrapperBase extends PoP_Module_Processor_ConditionWrapperBase
{
    public function getSocialmediaModule(array $module)
    {
        return null;
    }

    public function getConditionSucceededSubmodules(array $module)
    {
        $ret = parent::getConditionSucceededSubmodules($module);

        $ret[] = $this->getSocialmediaModule($module);

        return $ret;
    }

    public function getConditionField(array $module): ?string
    {
        return FieldQueryInterpreterFacade::getInstance()->getField('is-status', ['status' => POP_POSTSTATUS_PUBLISHED], 'published');
    }

    public function initModelProps(array $module, array &$props)
    {
        $this->appendProp($module, $props, 'class', 'pop-hidden-print');
        parent::initModelProps($module, $props);
    }
}
