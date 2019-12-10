<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

class GD_CreateUpdate_Event extends GD_CreateUpdate_PostBase
{
    protected function volunteer()
    {
        return true;
    }

    // Update Post Validation
    protected function validatecontent(&$errors, $form_data)
    {
        parent::validatecontent($errors, $form_data);

        // Validate for any status (even "draft"), since without date EM doesn't create the Event
        if (empty(array_filter(array_values($form_data['when'])))) {
            $errors[] = TranslationAPIFacade::getInstance()->__('The dates/time cannot be empty', 'poptheme-wassup');
        }
    }

    protected function getFormData(&$data_properties)
    {
        $form_data = parent::getFormData($data_properties);

        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $form_data['location'] = $location = $moduleprocessor_manager->getProcessor([PoP_Module_Processor_SelectableTypeaheadMapFormComponents::class, PoP_Module_Processor_SelectableTypeaheadMapFormComponents::MODULE_EM_FORMCOMPONENT_SINGLELOCATIONTYPEAHEADMAP])->getValue([PoP_Module_Processor_SelectableTypeaheadMapFormComponents::class, PoP_Module_Processor_SelectableTypeaheadMapFormComponents::MODULE_EM_FORMCOMPONENT_SINGLELOCATIONTYPEAHEADMAP]);
        $form_data['when'] = $moduleprocessor_manager->getProcessor([PoP_Module_Processor_DateRangeComponentInputs::class, PoP_Module_Processor_DateRangeComponentInputs::MODULE_FORMINPUT_DATERANGETIMEPICKER])->getValue([PoP_Module_Processor_DateRangeComponentInputs::class, PoP_Module_Processor_DateRangeComponentInputs::MODULE_FORMINPUT_DATERANGETIMEPICKER]);
        
        return $form_data;
    }

    protected function getCreatepostData($form_data)
    {
        $post_data = parent::getCreatepostData($form_data);
        $post_data = $this->getCreateupdatepostData($post_data, $form_data);

        return $post_data;
    }

    protected function getUpdatepostData($form_data)
    {
        $post_data = parent::getUpdatepostData($form_data);
        $post_data = $this->getCreateupdatepostData($post_data, $form_data);

        return $post_data;
    }

    protected function getCreateupdatepostData($post_data, $form_data)
    {

        // Unset the cat, not needed with events
        unset($post_data['post-categories']);

        $post_data['when'] = $form_data['when'];
        $post_data['location'] = $form_data['location'];

        return $post_data;
    }

    protected function populate(&$EM_Event, $post_data)
    {
        $pluginapi = PoP_Events_APIFactory::getInstance();
        $pluginapi->populate($EM_Event, $post_data);

        return $EM_Event;
    }

    protected function save(&$EM_Event, $post_data)
    {
        $EM_Event = $this->populate($EM_Event, $post_data);
        $EM_Event->save();
        return $EM_Event->post_id;
    }

    protected function executeUpdatepost($post_data)
    {
        $EM_Event = new EM_Event($post_data['id'], 'post_id');
        return $this->save($EM_Event, $post_data);
    }

    protected function executeCreatepost($post_data)
    {
        $EM_Event = new EM_Event();
        return $this->save($EM_Event, $post_data);
    }
}

