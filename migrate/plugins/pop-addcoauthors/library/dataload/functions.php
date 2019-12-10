<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

HooksAPIFacade::getInstance()->addAction('gd_createupdate_post', 'gdCapSharewithprofiles', 10);
function gdCapSharewithprofiles($post_id)
{
    $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
        
    // Was the Share With Profiles field added to the form?
    $coauthors = $moduleprocessor_manager->getProcessor([GD_CAP_Module_Processor_UserSelectableTypeaheadFormInputs::class, GD_CAP_Module_Processor_UserSelectableTypeaheadFormInputs::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEAD_POSTCOAUTHORS])->getValue([GD_CAP_Module_Processor_UserSelectableTypeaheadFormInputs::class, GD_CAP_Module_Processor_UserSelectableTypeaheadFormInputs::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEAD_POSTCOAUTHORS]);
    $pluginapi = PoP_AddCoauthors_APIFactory::getInstance();
    $pluginapi->addCoauthors($post_id, $coauthors);
}
