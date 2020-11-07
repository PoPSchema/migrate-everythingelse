<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\Misc\GeneralUtils;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;

class GD_Login implements MutationResolverInterface
{
    public function execute(array &$errors, array &$errorcodes, array $form_data)
    {
        // If the user is already logged in, then return the error
        $vars = ApplicationState::getVars();
        $cmsusersapi = \PoPSchema\Users\FunctionAPIFactory::getInstance();
        $cmsusersresolver = \PoPSchema\Users\ObjectPropertyResolverFactory::getInstance();
        $cmsuseraccountapi = \PoP\UserAccount\FunctionAPIFactory::getInstance();
        if ($vars['global-userstate']['is-user-logged-in']) {
            $user_id = $vars['global-userstate']['current-user-id'];
            $error = sprintf(
                TranslationAPIFacade::getInstance()->__('You are already logged in as <a href="%s">%s</a>, <a href="%s">logout</a>?', 'pop-application'),
                $cmsusersapi->getUserURL($user_id),
                $cmsusersapi->getUserDisplayName($user_id),
                $cmsuseraccountapi->getLogoutURL()
            );
        } else {
            $username_or_email = $form_data['username_or_email'];
            $pwd = $form_data['pwd'];

            if ($username_or_email && $pwd) {
                // Find out if it was a username or an email that was provided
                $is_email = strpos($username_or_email, '@');
                if ($is_email) {
                    if ($user = $cmsusersapi->getUserByEmail($username_or_email)) {
                        $username = $cmsusersresolver->getUserLogin($user);
                    } else {
                        $error = TranslationAPIFacade::getInstance()->__('There is no user registered with that email address.');
                    }
                } else {
                    $username = $username_or_email;
                }

                if ($username) {
                    $credentials = array(
                        'login' => $username,
                        'password' => $pwd,
                        'remember' => true,
                    );
                    $loginResult = $cmsuseraccountapi->login($credentials);

                    if (GeneralUtils::isError($loginResult)) {
                        $error = $loginResult->getErrorMessage();
                    }
                }
            } else {
                $error = TranslationAPIFacade::getInstance()->__('Please supply your username and password.', 'pop-application');
            }
        }

        if ($error) {
            // Return error string
            $errors[] = $error;
            return;
        }

        $user = $loginResult;

        // Modify the routing-state with the newly logged in user info
        PoP_UserLogin_Engine_Utils::calculateAndSetVarsUserState(ApplicationState::$vars);

        $userID = $cmsusersresolver->getUserId($user);
        HooksAPIFacade::getInstance()->doAction('gd:user:loggedin', $userID);
        return $userID;
    }
}
