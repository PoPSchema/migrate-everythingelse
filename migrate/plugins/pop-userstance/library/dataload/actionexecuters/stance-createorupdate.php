<?php
use PoPSchema\CustomPostMutations\MutationResolvers\AbstractCreateUpdateCustomPostMutationResolverBridge;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

class PoP_UserStance_DataLoad_ActionExecuter_CreateOrUpdate_Stance extends AbstractCreateUpdateCustomPostMutationResolverBridge
{
    protected function supportsTitle()
    {
        return false;
    }

    public function getMutationResolverClass(): string
    {
        return GD_CreateOrUpdate_Stance::class;
    }

    public function getFormData(): array
    {
        $form_data = parent::getFormData();

        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $target = $moduleprocessor_manager->getProcessor([PoP_UserStance_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_UserStance_Module_Processor_PostTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_STANCETARGET])->getValue([PoP_UserStance_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_UserStance_Module_Processor_PostTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_STANCETARGET]);
        $form_data['stancetarget'] = $target;

        return $form_data;
    }
}

