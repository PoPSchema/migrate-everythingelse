<?php
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

class GD_CreateUpdate_PostLink extends GD_CreateUpdate_PostBase
{
    protected function getCategories()
    {
        $ret = parent::getCategories();
        $ret[] = POP_CONTENTPOSTLINKS_CAT_CONTENTPOSTLINKS;
        return $ret;
    }

    protected function validatecontent(&$errors, $form_data)
    {
        parent::validatecontent($errors, $form_data);
        Wassup_CreateUpdate_Link_Utils::validatecontent($errors, $form_data);
    }

    protected function getEditorInput()
    {
        return [PoP_Module_Processor_CreateUpdatePostTextFormInputs::class, PoP_Module_Processor_CreateUpdatePostTextFormInputs::MODULE_CONTENTPOSTLINKS_FORMINPUT_LINK];
    }

    protected function getFormData(&$data_properties)
    {
        $form_data = parent::getFormData($data_properties);

        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        if (PoP_ApplicationProcessors_Utils::addLinkAccesstype()) {
            $form_data = array_merge(
                $form_data,
                array(
                    'linkaccess' => $moduleprocessor_manager->getProcessor([PoP_Module_Processor_CreateUpdatePostSelectFormInputs::class, PoP_Module_Processor_CreateUpdatePostSelectFormInputs::MODULE_CONTENTPOSTLINKS_FORMINPUT_LINKACCESS])->getValue([PoP_Module_Processor_CreateUpdatePostSelectFormInputs::class, PoP_Module_Processor_CreateUpdatePostSelectFormInputs::MODULE_CONTENTPOSTLINKS_FORMINPUT_LINKACCESS]),
                )
            );
        }

        return $form_data;
    }

    protected function additionals($post_id, $form_data)
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        parent::additionals($post_id, $form_data);

        if (PoP_ApplicationProcessors_Utils::addLinkAccesstype()) {
            \PoP\CustomPostMeta\Utils::updateCustomPostMeta($post_id, GD_METAKEY_POST_LINKACCESS, $form_data['linkaccess'], true);
        }
    }
}
