<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

class GD_CreateUpdate_Profile extends GD_CreateUpdate_User
{
    protected function getRole()
    {
        return GD_ROLE_PROFILE;
    }

    protected function validatecontent(&$errors, $form_data)
    {
        parent::validatecontent($errors, $form_data);

        // Allow to validate the extra inputs
        $hooked_errors = HooksAPIFacade::getInstance()->applyFilters('gd_createupdate_profile:validatecontent', array(), $form_data);
        foreach ($hooked_errors as $error) {
            $errors[] = $error;
        }
    }

    private function getFormInputs()
    {
        $inputs = HooksAPIFacade::getInstance()->applyFilters(
            'GD_CreateUpdate_Profile:form-inputs',
            array(
                'short_description' => null,
                'display_email' => null,
                'facebook' => null,
                'twitter' => null,
                'linkedin' => null,
                'youtube' => null,
                'instagram' => null,
                // 'blog' => null,
            )
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
        $form_data = parent::getFormData($data_properties);

        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $inputs = $this->getFormInputs();
        $form_data = array_merge(
            $form_data,
            array(
                'short_description' => trim($moduleprocessor_manager->getProcessor($inputs['short_description'])->getValue($inputs['short_description'])),
                'display_email' => $moduleprocessor_manager->getProcessor($inputs['display_email'])->getValue($inputs['display_email']),
                'facebook' => trim($moduleprocessor_manager->getProcessor($inputs['facebook'])->getValue($inputs['facebook'])),
                'twitter' => trim($moduleprocessor_manager->getProcessor($inputs['twitter'])->getValue($inputs['twitter'])),
                'linkedin' => trim($moduleprocessor_manager->getProcessor($inputs['linkedin'])->getValue($inputs['linkedin'])),
                'youtube' => trim($moduleprocessor_manager->getProcessor($inputs['youtube'])->getValue($inputs['youtube'])),
                'instagram' => trim($moduleprocessor_manager->getProcessor($inputs['instagram'])->getValue($inputs['instagram'])),
                // 'blog' => trim($moduleprocessor_manager->getProcessor($inputs['blog'])->getValue($inputs['blog'])),
            )
        );

        // Allow to add extra inputs
        $form_data = HooksAPIFacade::getInstance()->applyFilters('gd_createupdate_profile:form_data', $form_data);
        
        return $form_data;
    }

    protected function additionals($user_id, $form_data)
    {
        parent::additionals($user_id, $form_data);
        HooksAPIFacade::getInstance()->doAction('gd_createupdate_profile:additionals', $user_id, $form_data);
    }
    protected function additionalsUpdate($user_id, $form_data)
    {
        parent::additionalsUpdate($user_id, $form_data);
        HooksAPIFacade::getInstance()->doAction('gd_createupdate_profile:additionalsUpdate', $user_id, $form_data);
    }
    protected function additionalsCreate($user_id, $form_data)
    {
        parent::additionalsCreate($user_id, $form_data);

        HooksAPIFacade::getInstance()->doAction('gd_createupdate_profile:additionalsCreate', $user_id, $form_data);
    }
    protected function createupdateuser($user_id, $form_data)
    {
        parent::createupdateuser($user_id, $form_data);

        // Last Edited: needed for the user thumbprint
        \PoPSchema\UserMeta\Utils::updateUserMeta($user_id, GD_METAKEY_PROFILE_LASTEDITED, POP_CONSTANT_CURRENTTIMESTAMP);

        \PoPSchema\UserMeta\Utils::updateUserMeta($user_id, GD_METAKEY_PROFILE_DISPLAYEMAIL, $form_data['display_email'], true, true);
        \PoPSchema\UserMeta\Utils::updateUserMeta($user_id, GD_METAKEY_PROFILE_SHORTDESCRIPTION, $form_data['short_description'], true);

        // Comment Leo 05/12/2016: LinkedIn is removed from AgendaUrbana, however we don't check for the condition here, so it will still save null
        \PoPSchema\UserMeta\Utils::updateUserMeta($user_id, GD_METAKEY_PROFILE_FACEBOOK, $form_data['facebook'], true);
        \PoPSchema\UserMeta\Utils::updateUserMeta($user_id, GD_METAKEY_PROFILE_TWITTER, $form_data['twitter'], true);
        \PoPSchema\UserMeta\Utils::updateUserMeta($user_id, GD_METAKEY_PROFILE_LINKEDIN, $form_data['linkedin'], true);
        \PoPSchema\UserMeta\Utils::updateUserMeta($user_id, GD_METAKEY_PROFILE_YOUTUBE, $form_data['youtube'], true);
        \PoPSchema\UserMeta\Utils::updateUserMeta($user_id, GD_METAKEY_PROFILE_INSTAGRAM, $form_data['instagram'], true);
    }
}

