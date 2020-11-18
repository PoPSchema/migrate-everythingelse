<?php
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoPSitesWassup\FormMutations\MutationResolverBridges\AbstractFormComponentMutationResolverBridge;

class GD_DataLoad_ActionExecuter_NewsletterSubscription extends AbstractFormComponentMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return PoP_ActionExecuterInstance_SubscribeToNewsletter::class;
    }

    public function getFormData(): array
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $form_data = array(
            'email' => $moduleprocessor_manager->getProcessor([PoP_Newsletter_Module_Processor_TextFormInputs::class, PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTEREMAIL])->getValue([PoP_Newsletter_Module_Processor_TextFormInputs::class, PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTEREMAIL]),
            'name' => $moduleprocessor_manager->getProcessor([PoP_Newsletter_Module_Processor_TextFormInputs::class, PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTERNAME])->getValue([PoP_Newsletter_Module_Processor_TextFormInputs::class, PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTERNAME]),
        );

        return $form_data;
    }
}

