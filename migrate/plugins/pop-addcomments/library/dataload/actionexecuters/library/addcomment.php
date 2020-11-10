<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\State\ApplicationState;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;

class GD_AddComment extends AbstractMutationResolver
{
    public function validateErrors(array $form_data): ?array
    {
        $errors = [];
        if (empty($form_data['customPostID'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('We don\'t know what post the comment is for. Please reload the page and try again.', 'pop-application');
        }
        if (empty($form_data['comment'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('The comment is empty.', 'pop-application');
        }
        return $errors;
    }

    /**
     * Function to override
     */
    protected function additionals($comment_id, $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('gd_addcomment', $comment_id, $form_data);
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

    protected function insertComment($comment_data)
    {
        $cmscommentsapi = \PoPSchema\Comments\FunctionAPIFactory::getInstance();
        return $cmscommentsapi->insertComment($comment_data);
    }

    /**
     * @param string[] $errors
     * @return mixed|null
     */
    /**
     * @return mixed
     */
    public function execute(array $form_data)
    {
        $comment_data = $this->getCommentData($form_data);
        $comment_id = $this->insertComment($comment_data);

        // Allow for additional operations (eg: set Action categories)
        $this->additionals($comment_id, $form_data);

        return $comment_id;
    }
}

