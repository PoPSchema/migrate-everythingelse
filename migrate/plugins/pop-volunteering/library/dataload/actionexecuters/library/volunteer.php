<?php

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoPSchema\CustomPosts\Facades\CustomPostTypeAPIFacade;

class PoP_ActionExecuterInstance_Volunteer
{
    protected function validate(&$errors, $form_data)
    {
        if (empty($form_data['name'])) {
            $errors->add('emptyname', TranslationAPIFacade::getInstance()->__('Your name cannot be empty.', 'pop-genericforms'));
        }

        if (empty($form_data['email'])) {
            $errors->add('emptyemail', TranslationAPIFacade::getInstance()->__('Email cannot be empty.', 'pop-genericforms'));
        } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors->add('emailformatincorrect', TranslationAPIFacade::getInstance()->__('Email format is incorrect.', 'pop-genericforms'));
        }

        if (empty($form_data['target-id'])) {
            $errors->add('emptytargetid', TranslationAPIFacade::getInstance()->__('The requested post cannot be empty.', 'pop-genericforms'));
        } else {
            // Make sure the post exists
            $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
            $target = $customPostTypeAPI->getCustomPost($form_data['target-id']);
            if (!$target) {
                $errors->add('nonexistanttargetid', TranslationAPIFacade::getInstance()->__('The requested post does not exist.', 'pop-genericforms'));
            }
        }

        if (empty($form_data['whyvolunteer'])) {
            $errors->add('emptywhyvolunteer', TranslationAPIFacade::getInstance()->__('Why volunteer cannot be empty.', 'pop-genericforms'));
        }
    }

    /**
     * Function to override
     */
    protected function additionals($form_data)
    {
        HooksAPIFacade::getInstance()->doAction('pop_volunteer', $form_data);
    }

    protected function getFormData(&$data_properties)
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $form_data = array(
            'name' => $moduleprocessor_manager->getProcessor([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NAME])->getValue([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NAME]),
            'email' => $moduleprocessor_manager->getProcessor([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_EMAIL])->getValue([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_EMAIL]),
            'phone' => $moduleprocessor_manager->getProcessor([PoP_Volunteering_Module_Processor_TextFormInputs::class, PoP_Volunteering_Module_Processor_TextFormInputs::MODULE_FORMINPUT_PHONE])->getValue([PoP_Volunteering_Module_Processor_TextFormInputs::class, PoP_Volunteering_Module_Processor_TextFormInputs::MODULE_FORMINPUT_PHONE]),
            'whyvolunteer' => $moduleprocessor_manager->getProcessor([PoP_Volunteering_Module_Processor_TextareaFormInputs::class, PoP_Volunteering_Module_Processor_TextareaFormInputs::MODULE_FORMINPUT_WHYVOLUNTEER])->getValue([PoP_Volunteering_Module_Processor_TextareaFormInputs::class, PoP_Volunteering_Module_Processor_TextareaFormInputs::MODULE_FORMINPUT_WHYVOLUNTEER]),
            'target-id' => $moduleprocessor_manager->getProcessor([PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_POST])->getValue([PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_POST]),
        );

        return $form_data;
    }

    protected function execute($form_data)
    {
        $cmsapplicationapi = \PoP\Application\FunctionAPIFactory::getInstance();
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        $post_title = $customPostTypeAPI->getTitle($form_data['target-id']);
        $subject = sprintf(
            TranslationAPIFacade::getInstance()->__('[%s]: %s', 'pop-genericforms'),
            $cmsapplicationapi->getSiteName(),
            sprintf(
                TranslationAPIFacade::getInstance()->__('%s applied to volunteer for %s', 'pop-genericforms'),
                $form_data['name'],
                $post_title
            )
        );
        $placeholder = '<p><b>%s:</b> %s</p>';
        $msg = sprintf(
            '<p>%s</p>',
            TranslationAPIFacade::getInstance()->__('You have a new volunteer! Please contact the volunteer directly through the contact details below.', 'pop-genericforms')
        ).sprintf(
            '<p>%s</p>',
            sprintf(
                TranslationAPIFacade::getInstance()->__('%s applied to volunteer for: <a href="%s">%s</a>', 'pop-genericforms'),
                $form_data['name'],
                $customPostTypeAPI->getPermalink($form_data['target-id']),
                $post_title
            )
        ).sprintf(
            $placeholder,
            TranslationAPIFacade::getInstance()->__('Email', 'pop-genericforms'),
            sprintf(
                '<a href="mailto:%1$s">%1$s</a>',
                $form_data['email']
            )
        ).sprintf(
            $placeholder,
            TranslationAPIFacade::getInstance()->__('Phone', 'pop-genericforms'),
            $form_data['phone']
        ).sprintf(
            $placeholder,
            TranslationAPIFacade::getInstance()->__('Why volunteer', 'pop-genericforms'),
            $form_data['whyvolunteer']
        );

        return PoP_EmailSender_Utils::sendemailToUsersFromPost(array($form_data['target-id']), $subject, $msg);
    }

    public function volunteer(&$data_properties)
    {
        $form_data = $this->getFormData($data_properties);

        $errors = new \PoP\ComponentModel\Error();
        $this->validate($errors, $form_data);
        if ($errors->getErrorCodes()) {
            return $errors;
        }

        $result = $this->execute($form_data);
        // if (GeneralUtils::isError($result)) {
        //     foreach ($result->getErrorMessages() as $error_msg) {
        //         $errors[] = $error_msg;
        //     }
        //     return;
        // }

        // Allow for additional operations
        $this->additionals($form_data);

        return $result;
    }
}
