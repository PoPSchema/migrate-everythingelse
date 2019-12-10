<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

class GD_CreateUpdate_User
{
    protected function getRole()
    {
        return 'subscriber';
    }

    protected function validatecontent(&$errors, $form_data)
    {
        if (empty($form_data['first_name'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('The name cannot be empty', 'pop-application');
        }

        // Validate email
        $user_email = $form_data['user_email'];
        if ($user_email == '') {
            $errors[] = TranslationAPIFacade::getInstance()->__('The e-mail cannot be empty', 'pop-application');
        } elseif (! is_email($user_email)) {
            $errors[] = TranslationAPIFacade::getInstance()->__('The email address isn&#8217;t correct.', 'pop-application');
        }

        $limited_email_domains = get_site_option('limited_email_domains');
        if (is_array($limited_email_domains) && empty($limited_email_domains) == false) {
            $emaildomain = substr($user_email, 1 + strpos($user_email, '@'));
            if (in_array($emaildomain, $limited_email_domains) == false) {
                $errors[] = TranslationAPIFacade::getInstance()->__('That email address is not allowed!', 'pop-application');
            }
        }
    }

    protected function validatecreatecontent(&$errors, $form_data)
    {

        // Check the username
        $user_login = $form_data['username'];
        if ($user_login == '') {
            $errors[] = TranslationAPIFacade::getInstance()->__('The username cannot be empty.', 'pop-application');
        } elseif (! validate_username($user_login)) {
            $errors[] = TranslationAPIFacade::getInstance()->__('This username is invalid because it uses illegal characters. Please enter a valid username.', 'pop-application');
        } elseif (username_exists($user_login)) {
            $errors[] = TranslationAPIFacade::getInstance()->__('This username is already registered. Please choose another one.', 'pop-application');
        }

        // Check the e-mail address
        $user_email = $form_data['user_email'];
        if (email_exists($user_email)) {
            $errors[] = TranslationAPIFacade::getInstance()->__('This email is already registered, please choose another one.', 'pop-application');
        }

        // Validate Password
        $password = $form_data['password'];
        $repeatpassword =  $form_data['repeat_password'];
        
        if (!$password) {
            $errors[] = TranslationAPIFacade::getInstance()->__('The password cannot be emtpy.', 'pop-application');
        } elseif (strlen($password) < 8) {
            $errors[] = TranslationAPIFacade::getInstance()->__('The password must be at least 8 characters long.', 'pop-application');
        } else {
            if (!$repeatpassword) {
                $errors[] = TranslationAPIFacade::getInstance()->__('Please confirm the password.', 'pop-application');
            } elseif ($password !== $repeatpassword) {
                $errors[] = TranslationAPIFacade::getInstance()->__('Passwords do not match.', 'pop-application');
            }
        }

        // Validate the captcha
        if (PoP_Forms_ConfigurationUtils::captchaEnabled()) {
            $captcha = $form_data['captcha'];
            
            $captcha_validation = GD_Captcha::validate($captcha);
            if (\PoP\ComponentModel\GeneralUtils::isError($captcha_validation)) {
                $errors[] = $captcha_validation->getErrorMessage();
            }
        }
    }

    protected function validateupdatecontent(&$errors, $form_data)
    {
        $user_id = $form_data['user_id'];
        $user_email = $form_data['user_email'];

        $email_user_id = email_exists($user_email);
        if ($email_user_id && $email_user_id !== $user_id) {
            $errors[] = TranslationAPIFacade::getInstance()->__('That email address already exists in our system!', 'pop-application');
        }
    }

    private function getFormInputs()
    {
        $form_inputs = array(
            'username' => null,
            'password' => null,
            'repeat_password' => null,
            'first_name' => null,
            'user_email' => null,
            'description' => null,
            'user_url' => null,
        );

        if (PoP_Forms_ConfigurationUtils::captchaEnabled()) {
            $form_inputs['captcha'] = null;
        }

        $inputs = HooksAPIFacade::getInstance()->applyFilters(
            'GD_CreateUpdate_User:form-inputs',
            $form_inputs
        );

        // If any input is null, throw an exception
        $null_inputs = array_filter($inputs, 'is_null');
        if ($null_inputs) {
            throw new Exception(
                sprintf(
                    'No form inputs defined for: %s',
                    '"'.implode('", "', array_keys($null_inputs)).'"'
                )
            );
        }

        return $inputs;
    }

    protected function getFormData(&$data_properties)
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $cmseditusershelpers = \PoP\EditUsers\HelperAPIFactory::getInstance();
        $cmsapplicationhelpers = \PoP\Application\HelperAPIFactory::getInstance();
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $user_id = $vars['global-userstate']['is-user-logged-in'] ? $vars['global-userstate']['current-user-id'] : '';
        $inputs = $this->getFormInputs();
        $form_data = array(
            'user_id' => $user_id,
            'username' => $cmseditusershelpers->sanitizeUsername($moduleprocessor_manager->getProcessor($inputs['username'])->getValue($inputs['username'])),
            'password' => $moduleprocessor_manager->getProcessor($inputs['password'])->getValue($inputs['password']),
            'repeat_password' => $moduleprocessor_manager->getProcessor($inputs['repeat_password'])->getValue($inputs['repeat_password']),
            'first_name' => trim($cmsapplicationhelpers->escapeAttributes($moduleprocessor_manager->getProcessor($inputs['first_name'])->getValue($inputs['first_name']))),
            'user_email' => trim($moduleprocessor_manager->getProcessor($inputs['user_email'])->getValue($inputs['user_email'])),
            'description' => trim($moduleprocessor_manager->getProcessor($inputs['description'])->getValue($inputs['description'])),
            'user_url' => trim($moduleprocessor_manager->getProcessor($inputs['user_url'])->getValue($inputs['user_url'])),
        );

        if (PoP_Forms_ConfigurationUtils::captchaEnabled()) {
            $form_data['captcha'] = $moduleprocessor_manager->getProcessor($inputs['captcha'])->getValue($inputs['captcha']);
        }

        // Allow to add extra inputs
        $form_data = HooksAPIFacade::getInstance()->applyFilters('gd_createupdate_user:form_data', $form_data);
        
        return $form_data;
    }

    protected function getCreateuserFormData(&$data_properties)
    {
        $form_data = $this->getFormData($data_properties);

        // Allow to add extra inputs
        $form_data = HooksAPIFacade::getInstance()->applyFilters('gd_createupdate_user:form_data:create', $form_data);
        
        return $form_data;
    }

    protected function getUpdateuserFormData(&$data_properties)
    {
        $form_data = $this->getFormData($data_properties);

        // Allow to add extra inputs
        $form_data = HooksAPIFacade::getInstance()->applyFilters('gd_createupdate_user:form_data:update', $form_data);
        
        return $form_data;
    }

    protected function getUpdateuserData($form_data)
    {
        $user_data = array(
            'id' => $form_data['user_id'],
            'firstname' => $form_data['first_name'],
            'email' => $form_data['user_email'],
            'description' => $form_data['description'],
            'url' => $form_data['user_url']
        );

        return $user_data;
    }

    protected function getCreateuserData($form_data)
    {
        $user_data = $this->getUpdateuserData($form_data);
        
        // ID not needed
        unset($user_data['id']);

        // Assign the role only when creating a user
        $user_data['role'] = $this->getRole();

        // Add the password
        $user_data['password'] = $form_data['password'];

        // Username
        $user_data['login'] = $form_data['username'];

        return $user_data;
    }

    protected function executeUpdateuser($user_data)
    {
        $cmseditusersapi = \PoP\EditUsers\FunctionAPIFactory::getInstance();
        return $cmseditusersapi->updateUser($user_data);
    }

    protected function createupdateuser($user_id, $form_data)
    {
    }

    protected function updateuser(&$errors, $form_data)
    {
        $user_data = $this->getUpdateuserData($form_data);
        $user_id = $user_data['id'];
        
        $result = $this->executeUpdateuser($user_data);

        if (\PoP\ComponentModel\GeneralUtils::isError($result)) {
            $errors[] = sprintf(
                TranslationAPIFacade::getInstance()->__('Ops, there was a problem: %s', 'pop-application'),
                $result->getErrorMessage()
            );
            return;
        }

        $this->createupdateuser($user_id, $form_data);

        return $user_id;
    }

    protected function executeCreateuser($user_data)
    {
        $cmseditusersapi = \PoP\EditUsers\FunctionAPIFactory::getInstance();
        return $cmseditusersapi->insertUser($user_data);
    }

    protected function createuser(&$errors, $form_data)
    {
        $user_data = $this->getCreateuserData($form_data);
        $result = $this->executeCreateuser($user_data);

        if (\PoP\ComponentModel\GeneralUtils::isError($result)) {
            $errors[] = sprintf(
                TranslationAPIFacade::getInstance()->__('Ops, there was a problem: %s', 'pop-application'),
                $result->getErrorMessage()
            );
            return;
        }

        $user_id = $result;
        
        $this->createupdateuser($user_id, $form_data);

        return $user_id;
    }

    public function createOrUpdate(&$errors, &$data_properties)
    {

        // If user is logged in => It's Update
        // Otherwise => It's Create
        
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        if ($vars['global-userstate']['is-user-logged-in']) {
            $this->update($errors, $data_properties);
            return 'update';
        }

        $this->create($errors, $data_properties);
        return 'create';
    }
    
    protected function additionals($user_id, $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('gd_createupdate_user:additionals', $user_id, $form_data);
    }
    protected function additionalsUpdate($user_id, $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('gd_createupdate_user:additionalsUpdate', $user_id, $form_data);
    }
    protected function additionalsCreate($user_id, $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('gd_createupdate_user:additionalsCreate', $user_id, $form_data);
    }

    protected function update(&$errors, &$data_properties)
    {
        $form_data = $this->getUpdateuserFormData($data_properties);

        $this->validatecontent($errors, $form_data);
        $this->validateupdatecontent($errors, $form_data);
        if ($errors) {
            return;
        }

        // Do the Post update
        $user_id = $this->updateuser($errors, $form_data);

        // Allow for additional operations (eg: set Action categories)
        $this->additionalsUpdate($user_id, $form_data);
        $this->additionals($user_id, $form_data);

        // Trigger to update the display_name and nickname
        userNameUpdated($user_id);
    }

    protected function create(&$errors, &$data_properties)
    {
        $form_data = $this->getCreateuserFormData($data_properties);

        $this->validatecontent($errors, $form_data);
        $this->validatecreatecontent($errors, $form_data);
        if ($errors) {
            return;
        }

        $user_id = $this->createuser($errors, $form_data);

        // Allow for additional operations (eg: set Action categories)
        $this->additionalsCreate($user_id, $form_data);
        $this->additionals($user_id, $form_data);

        // Comment Leo 21/09/2015: we don't use this function anymore to send the notifications to the admin/user. Instead, use our own hooks.
        // Send notification of new user
        // wpNewUserNotification( $user_id, $form_data['password'] );
    }
}
