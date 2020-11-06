<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

trait GD_UserCommunities_CreateUpdate_Profile_Trait
{
    // public function getFormData(): array
    // {
    //     return array_merge(
    //         parent::getFormData(),
    //         $this->getUsercommunitiesFormData()
    //     );
    // }
    protected function getUsercommunitiesFormData()
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
        $inputs = GD_UserCommunities_MyCommunitiesUtils::getFormInputs();
        $communities = $moduleprocessor_manager->getProcessor($inputs['communities'])->getValue($inputs['communities']);
        return array(
            'communities' => $communities ?? array(),
        );
    }
}
