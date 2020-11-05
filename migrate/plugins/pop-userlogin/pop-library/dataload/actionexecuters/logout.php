<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;

class GD_DataLoad_ActionExecuter_Logout implements ComponentMutationResolverBridgeInterface
{
    /**
     * @param array $data_properties
     * @return array<string, mixed>|null
     */
    public function execute(array &$data_properties): ?array
    {

        // If the post has been submitted, execute the Gravity Forms shortcode
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            // If the user is not logged in, then return the error
            $vars = ApplicationState::getVars();
            if (!$vars['global-userstate']['is-user-logged-in']) {
                $error = TranslationAPIFacade::getInstance()->__('You are not logged in.', 'pop-application');

                // Return error string
                return array(
                    ResponseConstants::ERRORSTRINGS => array($error)
                );
            }

            $user_id = $vars['global-userstate']['current-user-id'];

            $cmsuseraccountapi = \PoP\UserAccount\FunctionAPIFactory::getInstance();
            $cmsuseraccountapi->logout();

            // Modify the routing-state with the newly logged in user info
            PoP_UserLogin_Engine_Utils::calculateAndSetVarsUserState(ApplicationState::$vars);

            HooksAPIFacade::getInstance()->doAction('gd:user:loggedout', $user_id);

            return array(
                ResponseConstants::SUCCESS => true
            );
        }

        return null;
    }
}

