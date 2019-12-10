<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;

class GD_DataLoad_ActionExecuter_Logout implements \PoP\ComponentModel\ActionExecuterInterface
{
    public function execute(&$data_properties)
    {

        // If the post has been submitted, execute the Gravity Forms shortcode
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            // If the user is not logged in, then return the error
            $vars = \PoP\ComponentModel\Engine_Vars::getVars();
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
            PoP_UserLogin_Engine_Utils::calculateAndSetVarsUserState(\PoP\ComponentModel\Engine_Vars::$vars);

            HooksAPIFacade::getInstance()->doAction('gd:user:loggedout', $user_id);

            return array(
                ResponseConstants::SUCCESS => true
            );
        }

        return null;
    }
}
    
