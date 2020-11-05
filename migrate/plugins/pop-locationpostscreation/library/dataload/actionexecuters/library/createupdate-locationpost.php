<?php
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoPSchema\PostMutations\MutationResolvers\AbstractCreateUpdatePostMutationResolver;

abstract class GD_CreateUpdate_LocationPost extends AbstractCreateUpdatePostMutationResolver
{
    protected function getCustomPostType($form_data)
    {
        return POP_LOCATIONPOSTS_POSTTYPE_LOCATIONPOST;
    }

    protected function volunteer()
    {
        return true;
    }

    protected function getFormData()
    {
        $form_data = parent::getFormData();

        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $locations = $moduleprocessor_manager->getProcessor([PoP_Module_Processor_SelectableTypeaheadMapFormComponents::class, PoP_Module_Processor_SelectableTypeaheadMapFormComponents::MODULE_EM_FORMCOMPONENT_TYPEAHEADMAP])->getValue([PoP_Module_Processor_SelectableTypeaheadMapFormComponents::class, PoP_Module_Processor_SelectableTypeaheadMapFormComponents::MODULE_EM_FORMCOMPONENT_TYPEAHEADMAP]);
        $form_data = array_merge(
            $form_data,
            array(
                'locations' => $locations ?? array(),
            )
        );

        return $form_data;
    }

    protected function additionals($post_id, $form_data)
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        parent::additionals($post_id, $form_data);

        // Locations
        \PoPSchema\CustomPostMeta\Utils::updateCustomPostMeta($post_id, GD_METAKEY_POST_LOCATIONS, $form_data['locations']);
    }
}
