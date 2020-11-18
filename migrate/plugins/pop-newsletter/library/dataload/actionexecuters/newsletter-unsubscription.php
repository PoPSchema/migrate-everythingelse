<?php
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoPSitesWassup\FormMutations\MutationResolverBridges\AbstractFormComponentMutationResolverBridge;

class GD_DataLoad_ActionExecuter_NewsletterUnsubscription extends AbstractFormComponentMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return PoP_UnsubscribeFromNewsletter::class;
    }

    public function getFormData(): array
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $form_data = array(
            'email' => $moduleprocessor_manager->getProcessor([PoP_Newsletter_Module_Processor_TextFormInputs::class, PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTEREMAILVERIFICATIONEMAIL])->getValue([PoP_Newsletter_Module_Processor_TextFormInputs::class, PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTEREMAILVERIFICATIONEMAIL]),
            'verificationcode' => $moduleprocessor_manager->getProcessor([PoP_Newsletter_Module_Processor_TextFormInputs::class, PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTEREMAILVERIFICATIONCODE])->getValue([PoP_Newsletter_Module_Processor_TextFormInputs::class, PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTEREMAILVERIFICATIONCODE]),
        );

        return $form_data;
    }
}

