<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_UpdateUserMetaValue_User extends GD_UpdateUserMetaValue
{
    protected function validate(&$errors, $form_data)
    {
        parent::validate($errors, $form_data);

        if (!$errors) {
            $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
            $target_id = $form_data['target_id'];
            
            // Make sure the user exists
            $target = $cmsusersapi->getUserById($target_id);
            if (!$target) {
                $errors[] = TranslationAPIFacade::getInstance()->__('The requested user does not exist.', 'pop-coreprocessors');
            }
        }
    }

    protected function getRequestKey()
    {
        return POP_INPUTNAME_USERID;
    }

    protected function additionals($target_id, $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('gd_updateusermetavalue:user', $target_id, $form_data);
        parent::additionals($target_id, $form_data);
    }
}
