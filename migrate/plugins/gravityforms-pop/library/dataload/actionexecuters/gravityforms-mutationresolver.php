<?php
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

class GD_GravityForms implements MutationResolverInterface
{
    protected function getFormData()
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $formid_processor = $moduleprocessor_manager->getProcessor([GD_GF_Module_Processor_TextFormInputs::class, GD_GF_Module_Processor_TextFormInputs::MODULE_GF_FORMINPUT_FORMID]);
        $form_data = array(
            'form_id' => $formid_processor->getValue([GD_GF_Module_Processor_TextFormInputs::class, GD_GF_Module_Processor_TextFormInputs::MODULE_GF_FORMINPUT_FORMID]),
        );

        return $form_data;
    }

    public function execute(array &$errors, array &$errorcodes)
    {
        $form_data = $this->getFormData();

        // $execution_response = do_shortcode('[gravityform id="'.$form_id.'" title="false" description="false" ajax="false"]');
        return RGForms::get_form($form_data['form_id'], false, false);
    }
}
