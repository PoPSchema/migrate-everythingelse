<?php

abstract class GD_CreateUpdate_EventLink extends GD_CreateUpdate_Event
{
    protected function populate(&$EM_Event, $post_data)
    {

        // Add class "Link" on the event object
        if (!$EM_Event->get_categories()->terms[POP_EVENTLINKS_CAT_EVENTLINKS]) {
            $EM_Event->get_categories()->terms[POP_EVENTLINKS_CAT_EVENTLINKS] = new EM_Category(POP_EVENTLINKS_CAT_EVENTLINKS);
        }
        return parent::populate($EM_Event, $post_data);
    }


    /**
     *
     * --------------------------------------------------
     * Function below was copied from class GD_CreateUpdate_PostLink
    --------------------------------------------------
     */
    protected function validatecontent(&$errors, $form_data)
    {
        parent::validatecontent($errors, $form_data);
        Wassup_CreateUpdate_Link_Utils::validatecontent($errors, $form_data);
    }

    /**
     *
     * --------------------------------------------------
     * Function below was copied from class GD_CreateUpdate_PostLink
    --------------------------------------------------
     */
    protected function getEditorInput()
    {
        return [PoP_Module_Processor_CreateUpdatePostTextFormInputs::class, PoP_Module_Processor_CreateUpdatePostTextFormInputs::MODULE_CONTENTPOSTLINKS_FORMINPUT_LINK];
    }
}
