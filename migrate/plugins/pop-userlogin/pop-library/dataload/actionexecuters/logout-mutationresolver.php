<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;

class GD_Logout implements MutationResolverInterface
{
    public function execute(array &$errors, array &$errorcodes)
    {
        // If the user is not logged in, then return the error
        $vars = ApplicationState::getVars();
        if (!$vars['global-userstate']['is-user-logged-in']) {
            $error = TranslationAPIFacade::getInstance()->__('You are not logged in.', 'pop-application');

            // Return error string
            $errors[] = $error;
            return;
        }

        $user_id = $vars['global-userstate']['current-user-id'];

        $cmsuseraccountapi = \PoP\UserAccount\FunctionAPIFactory::getInstance();
        $cmsuseraccountapi->logout();

        // Modify the routing-state with the newly logged in user info
        PoP_UserLogin_Engine_Utils::calculateAndSetVarsUserState(ApplicationState::$vars);

        HooksAPIFacade::getInstance()->doAction('gd:user:loggedout', $user_id);
        return $user_id;
    }
}
