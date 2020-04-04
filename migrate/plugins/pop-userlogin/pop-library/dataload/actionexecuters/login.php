<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\Misc\GeneralUtils;

class GD_DataLoad_ActionExecuter_Login implements \PoP\ComponentModel\ActionExecuterInterface
{
    public function execute(&$data_properties)
    {

        // If the post has been submitted, execute the Gravity Forms shortcode
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $error = '';

            // If the user is already logged in, then return the error
            $vars = ApplicationState::getVars();
            $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
            $cmsusersresolver = \PoP\Users\ObjectPropertyResolverFactory::getInstance();
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
                $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
                $username_or_email = trim($moduleprocessor_manager->getProcessor([PoP_Module_Processor_LoginTextFormInputs::class, PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOGIN_USERNAME])->getValue([PoP_Module_Processor_LoginTextFormInputs::class, PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOGIN_USERNAME]));
                $pwd = $moduleprocessor_manager->getProcessor([PoP_Module_Processor_LoginTextFormInputs::class, PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOGIN_PWD])->getValue([PoP_Module_Processor_LoginTextFormInputs::class, PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOGIN_PWD]);

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
                return array(
                    ResponseConstants::ERRORSTRINGS => array($error)
                );
            }

            $user = $loginResult;

            // Modify the routing-state with the newly logged in user info
            PoP_UserLogin_Engine_Utils::calculateAndSetVarsUserState(ApplicationState::$vars);

            HooksAPIFacade::getInstance()->doAction('gd:user:loggedin', $cmsusersresolver->getUserId($user));

            return array(
                ResponseConstants::SUCCESS => true
            );
        }

        return null;
    }
}
    
