<?php
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoPSitesWassup\CustomPostMutations\MutationResolvers\AbstractCreateUpdateCustomPostMutationResolver;

class GD_CreateUpdate_PostLink extends AbstractCreateUpdateCustomPostMutationResolver
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

    protected function additionals($post_id, $form_data)
    {
        parent::additionals($post_id, $form_data);

        if (PoP_ApplicationProcessors_Utils::addLinkAccesstype()) {
            \PoPSchema\CustomPostMeta\Utils::updateCustomPostMeta($post_id, GD_METAKEY_POST_LINKACCESS, $form_data['linkaccess'], true);
        }
    }
}
