<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;

abstract class GD_DataLoad_ActionExecuter_CreateUpdate_UserBase extends AbstractComponentMutationResolverBridge
{
    /**
     * @param mixed $result_id Maybe an int, maybe a string
     */
    public function getSuccessString($result_id): ?string
    {
        // For the update, gotta return the success string
        if ($result_id == 'update') {
            // Allow PoP Service Workers to add the attr to avoid the link being served from the browser cache
            $vars = ApplicationState::getVars();
            return sprintf(
                TranslationAPIFacade::getInstance()->__('View your <a href="%s" target="%s" %s>updated profile</a>.', 'pop-application'),
                getAuthorProfileUrl($vars['global-userstate']['current-user-id']),
                PoP_Application_Utils::getPreviewTarget(),
                HooksAPIFacade::getInstance()->applyFilters('GD_DataLoad_ActionExecuter_CreateUpdate_UserBase:success_msg:linkattrs', '')
            );
        }
    }
}
