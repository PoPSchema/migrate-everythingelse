<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoP\ComponentModel\State\ApplicationState;

class GD_AddComment
{
    protected function validate(&$errors, $form_data)
    {
        if (empty($form_data['customPostID'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('We don\'t know what post the comment is for. Please reload the page and try again.', 'pop-application');
        }

        if (empty($form_data['comment'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('The comment is empty.', 'pop-application');
        }
    }

    /**
     * Function to override
     */
    protected function additionals($comment_id, $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('gd_addcomment', $comment_id, $form_data);
    }

    protected function getFormData(&$data_properties)
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $form_data = array(
            'comment' => $moduleprocessor_manager->getProcessor([PoP_Module_Processor_CommentEditorFormInputs::class, PoP_Module_Processor_CommentEditorFormInputs::MODULE_FORMINPUT_COMMENTEDITOR])->getValue([PoP_Module_Processor_CommentEditorFormInputs::class, PoP_Module_Processor_CommentEditorFormInputs::MODULE_FORMINPUT_COMMENTEDITOR]),
            'parent' => $moduleprocessor_manager->getProcessor([PoP_Application_Module_Processor_CommentTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_CommentTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_COMMENT])->getValue([PoP_Application_Module_Processor_CommentTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_CommentTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_COMMENT]),
            'customPostID' => $moduleprocessor_manager->getProcessor([PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_COMMENTPOST])->getValue([PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_COMMENTPOST]),
        );

        return $form_data;
    }

    protected function getCommentData($form_data)
    {
        // TODO: Integrate with `mustHaveUserAccountToAddComment`
        $cmsusersapi = \PoPSchema\Users\FunctionAPIFactory::getInstance();
        $vars = ApplicationState::getVars();
        $user_id = $vars['global-userstate']['current-user-id'];
        $author_url = $cmsusersapi->getUserURL($user_id);
        $comment_data = array(
            'userID' => $user_id,
            'author' => $cmsusersapi->getUserDisplayName($user_id),
            'authorEmail' => $cmsusersapi->getUserEmail($user_id),
            'author-URL' => $author_url,
            'author-IP' => $_SERVER['REMOTE_ADDR'],
            'agent' => $_SERVER['HTTP_USER_AGENT'],
            'content' => $form_data['comment'],
            'parent' => $form_data['parent'],
            'customPostID' => $form_data['customPostID']
        );

        return $comment_data;
    }

    protected function execute($comment_data)
    {
        $cmscommentsapi = \PoPSchema\Comments\FunctionAPIFactory::getInstance();
        return $cmscommentsapi->insertComment($comment_data);
    }

    public function addcomment(&$errors, &$data_properties)
    {
        $form_data = $this->getFormData($data_properties);

        $this->validate($errors, $form_data);
        if ($errors) {
            return;
        }

        $comment_data = $this->getCommentData($form_data);
        $comment_id = $this->execute($comment_data);

        // Allow for additional operations (eg: set Action categories)
        $this->additionals($comment_id, $form_data);

        return $comment_id;
    }
}

