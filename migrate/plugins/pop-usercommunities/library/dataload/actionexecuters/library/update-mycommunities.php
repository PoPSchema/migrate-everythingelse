<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\State\ApplicationState;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

class GD_Update_MyCommunities implements MutationResolverInterface
{
    public function execute(array &$errors, array &$errorcodes)
    {
        $form_data = $this->getFormData();

        $this->validateupdatecontent($errors, $form_data);
        if ($errors) {
            return;
        }

        // Do the Post update
        return $this->executeUpdate($errors, $form_data);
    }

    protected function getFormData()
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

    protected function validateupdatecontent(&$errors, $form_data)
    {
        $user_id = $form_data['user_id'];

        // Validate the Community doesn't belong to itself as a member
        if (in_array($user_id, $form_data['communities'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('You are not allowed to be a member of yourself!', 'ure-pop');
        }
    }

    protected function executeUpdate(&$errors, $form_data)
    {
        $cmsusersapi = \PoPSchema\Users\FunctionAPIFactory::getInstance();
        $user_id = $form_data['user_id'];

        $previous_communities = gdUreGetCommunities($user_id);
        $communities = $form_data['communities'];
        // $maybe_new_communities = array_diff($communities, $previous_communities);
        $new_communities = $banned_communities = array();

        $status = \PoPSchema\UserMeta\Utils::getUserMeta($user_id, GD_URE_METAKEY_PROFILE_COMMUNITIES_MEMBERSTATUS);

        // Check all the $maybe_new_communities and double check they are not banned
        foreach ($communities as $maybe_new_community) {
            // Empty metavalue => it's new
            $community_status = gdUreFindCommunityMetavalues($maybe_new_community, $status);
            if (empty($community_status)) {
                $new_communities[] = $maybe_new_community;
            } else {
                // Check if this user was banned by the community
                if (in_array(GD_URE_METAVALUE_PROFILE_COMMUNITIES_MEMBERSTATUS_REJECTED, $community_status)) {
                    $banned_communities[] = $maybe_new_community;
                }
            }
        }

        // Set the new communities
        \PoPSchema\UserMeta\Utils::updateUserMeta($user_id, GD_URE_METAKEY_PROFILE_COMMUNITIES, $communities);

        // Set the privileges/tags for the new communities
        gdUreUserAddnewcommunities($user_id, $new_communities);

        // If there are banned communities, show the corresponding error to the user
        if ($banned_communities) {
            $banned_communities_html = array();
            foreach ($banned_communities as $banned_community) {
                $banned_communities_html[] = sprintf(
                    '<a href="%s">%s</a>',
                    $cmsusersapi->getUserURL($banned_community),
                    $cmsusersapi->getUserDisplayName($banned_community)
                );
            }
            $errors[] = sprintf(
                TranslationAPIFacade::getInstance()->__('The following Community(ies) will not be active, since they claim you are not their member: %s.', 'ure-pop'),
                implode(', ', $banned_communities_html)
            );
        }

        // Keep the previous values as to analyse which communities are new and send an email only to those
        $operationlog = array(
            'previous-communities' => $previous_communities,
            'new-communities' => $new_communities,
            'communities' => $communities,
        );

        // Allow to send an email before the update: get the current communities, so we know which ones are new
        HooksAPIFacade::getInstance()->doAction('gd_update_mycommunities:update', $user_id, $form_data, $operationlog);

        return true;
        // Update: either updated or no banned communities (even if nothing changed, tell the user update was successful)
        // return $update || empty($banned_communities);
    }
}

