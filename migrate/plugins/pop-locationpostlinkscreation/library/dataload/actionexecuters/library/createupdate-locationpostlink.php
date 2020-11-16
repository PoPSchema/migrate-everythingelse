<?php

abstract class GD_CreateUpdate_LocationPostLink extends GD_CreateUpdate_LocationPost
{
    protected function getCategories()
    {
        $ret = parent::getCategories();
        if (defined('POP_LOCATIONPOSTLINKS_CAT_LOCATIONPOSTLINKS') && POP_LOCATIONPOSTLINKS_CAT_LOCATIONPOSTLINKS) {
            $ret[] = POP_LOCATIONPOSTLINKS_CAT_LOCATIONPOSTLINKS;
        }
        return $ret;
    }

    /**
     *
     * --------------------------------------------------
     * Function below was copied from class GD_CreateUpdate_PostLink
    --------------------------------------------------
     */
    protected function validateContent(array &$errors, array $form_data): void
    {
        parent::validateContent($errors, $form_data);
        Wassup_CreateUpdate_Link_Utils::validateContent($errors, $form_data);
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
