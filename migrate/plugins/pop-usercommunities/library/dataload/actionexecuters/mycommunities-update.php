<?php
use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;
use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

class GD_DataLoad_ActionExecuter_Update_MyCommunities extends AbstractComponentMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_Update_MyCommunities::class;
    }

    protected function returnIfError(): bool
    {
        // Allow for both success and errors (eg: some communities added, others not since they banned the user)
        return false;
    }

    public function getFormData(): array
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
        $vars = ApplicationState::getVars();
        $user_id = $vars['global-userstate']['is-user-logged-in'] ? $vars['global-userstate']['current-user-id'] : '';
        $inputs = GD_UserCommunities_MyCommunitiesUtils::getFormInputs();
        $communities = $moduleprocessor_manager->getProcessor($inputs['communities'])->getValue($inputs['communities']);
        $form_data = array(
            'user_id' => $user_id,
            'communities' => $communities ?? array(),
        );

        // Allow to add extra inputs
        $form_data = HooksAPIFacade::getInstance()->applyFilters('gd_createupdate_mycommunities:form_data', $form_data);

        return $form_data;
    }
}

