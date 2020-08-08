<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\Engine\Route\RouteUtils;
use PoP\ComponentModel\Misc\GeneralUtils;

class GD_DataLoad_ActionExecuter_LostPassword implements \PoP\ComponentModel\ActionExecuterInterface
{
    public function execute(&$data_properties)
    {

        // If the post has been submitted, execute the Gravity Forms shortcode
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
            $errors = array();
            $result = $this->retrievePassword($errors);
            if ($errors) {
                // Return error string
                return array(
                    ResponseConstants::ERRORSTRINGS => $errors
                );
            }

            // Redirect to the "Reset password" page
            return array(
                GD_DATALOAD_QUERYHANDLERRESPONSE_SOFTREDIRECT => RouteUtils::getRouteURL(POP_USERLOGIN_ROUTE_LOSTPWDRESET),
                ResponseConstants::SUCCESS => true,
            );
        }

        return null;
    }

    public function retrievePasswordMessage($key, $user_login, $user_id)
    {
        $code = GD_LostPasswordUtils::getCode($key, $user_login);
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        $cmsapplicationapi = \PoP\Application\FunctionAPIFactory::getInstance();

        // $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
        // $input_name = $moduleprocessor_manager->getProcessor([PoP_Module_Processor_LoginTextFormInputs::class, PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOSTPWDRESET_CODE])->getName([PoP_Module_Processor_LoginTextFormInputs::class, PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOSTPWDRESET_CODE]);
        $input_name = POP_INPUTNAME_CODE;
        $link = GeneralUtils::addQueryArgs([
            $input_name => $code, 
        ], RouteUtils::getRouteURL(POP_USERLOGIN_ROUTE_LOSTPWDRESET));

        $message = sprintf(
            '<p>%s</p><br/>',
            sprintf(
                TranslationAPIFacade::getInstance()->__('Someone requested that the password be reset for your account on <a href="%s">%s</a>. If this was a mistake, or if it was not you who requested the password reset, just ignore this email and nothing will happen.', 'pop-application'),
                GeneralUtils::maybeAddTrailingSlash($cmsengineapi->getHomeURL()),
                $cmsapplicationapi->getSiteName()
            )
        );
        $message .= sprintf(
            '<p>%s</p>',
            TranslationAPIFacade::getInstance()->__('To reset your password, please click on the following link:</p>', 'pop-application')
        );
        $message .= sprintf(
            '<p>%s</p><br/>',
            sprintf(
                '<a href="%1$s">%1$s</a>',
                $link
            )
        );
        $message .= sprintf(
            '<p>%s</p>',
            TranslationAPIFacade::getInstance()->__('Alternatively, please paste the following code in the "Code" input:', 'pop-application')
        );
        $message .= sprintf(
            // '<p><pre style="%s">%s</pre></p><br/>',
            // 'background-color: #f1f1f2; width: 100%; padding: 5px;',
            '<p><em>%s</em></p>',
            $code
        );

        return $message;
    }

    protected function getFormData(&$data_properties)
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $form_data = array(
            'user_login' => $moduleprocessor_manager->getProcessor([PoP_Module_Processor_LoginTextFormInputs::class, PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOSTPWD_USERNAME])->getValue([PoP_Module_Processor_LoginTextFormInputs::class, PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOSTPWD_USERNAME]),
        );
        
        return $form_data;
    }

    public function retrievePassword(&$errors)
    {
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        $cmsusersapi = \PoPSchema\Users\FunctionAPIFactory::getInstance();
        $cmsuseraccountapi = \PoP\UserAccount\FunctionAPIFactory::getInstance();
        $cmsusersresolver = \PoPSchema\Users\ObjectPropertyResolverFactory::getInstance();
        $form_data = $this->getFormData($data_properties);
        $user_login = $form_data['user_login'];

        // Code copied from file wp-login.php (We can't invoke it directly, since wp-login.php has not been loaded, and we can't do it since it executes a lot of unwanted code producing and output)
        if (empty($user_login)) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Enter a username or e-mail address.');
        } elseif (strpos($user_login, '@')) {
            $user = $cmsusersapi->getUserByEmail(trim($user_login));
            if (empty($user)) {
                $errors[] = TranslationAPIFacade::getInstance()->__('There is no user registered with that email address.');
            }
        } else {
            $login = trim($user_login);
            $user = $cmsusersapi->getUserByLogin($login);
        }

        if (!$user) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Invalid username or e-mail.');
        }

        if ($errors) {
            return;
        }

        // Generate something random for a password reset key.
        $key = $cmsuseraccountapi->getPasswordResetKey($user);

        if (GeneralUtils::isError($key)) {
            $errors[] = $key->getErrorCode();
            return;
        }

        /*
        * The blogname option is escaped with esc_html on the way into the database
        * in sanitize_option we want to reverse this for the plain text arena of emails.
        */
        // $site_name = wp_specialchars_decode($cmsapplicationapi->getSiteName(), ENT_QUOTES);
        // $title = sprintf(TranslationAPIFacade::getInstance()->__('[%s] Password Reset'), $site_name);
        $user_id = $cmsusersresolver->getUserId($user);
        $cmsapplicationapi = \PoP\Application\FunctionAPIFactory::getInstance();
        $title = sprintf(TranslationAPIFacade::getInstance()->__('[%s] Password Reset'), $cmsapplicationapi->getSiteName());
        $title = HooksAPIFacade::getInstance()->applyFilters('popcms:retrievePasswordTitle', $title, $user_login, $user);
        $message = $this->retrievePasswordMessage($key, $user_login, $user_id);
        $message = HooksAPIFacade::getInstance()->applyFilters('popcms:retrievePasswordMessage', $message, $key, $user_login, $user);

        $user_email = $cmsusersresolver->getUserEmail($user);
        $result = PoP_EmailSender_Utils::sendEmail($user_email, htmlspecialchars_decode($title)/*wp_specialchars_decode($title)*/, $message);
        if (GeneralUtils::isError($result)) {
            $errors[] = $result->getErrorCode();
            return;
        }
        return $result;
    }
}
    
