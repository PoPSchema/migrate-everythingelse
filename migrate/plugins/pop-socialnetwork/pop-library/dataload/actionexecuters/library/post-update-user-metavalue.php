<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

class GD_UpdateUserMetaValue_Post extends GD_UpdateUserMetaValue
{
    protected function eligible($post)
    {
        return true;
    }

    protected function validate(&$errors, $form_data)
    {
        parent::validate($errors, $form_data);

        if (!$errors) {
            $target_id = $form_data['target_id'];
            
            // Make sure the post exists
            $cmspostsapi = PostTypeAPIFacade::getInstance();
            $target = $cmspostsapi->getPost($target_id);
            if (!$target) {
                $errors[] = TranslationAPIFacade::getInstance()->__('The requested post does not exist.', 'pop-coreprocessors');
            } else {
                // Make sure this target accepts this functionality. Eg: Not all posts can be Recommended or Up/Down-voted.
                // Discussion can be recommended only, Highlight up/down-voted only
                if (!$this->eligible($target)) {
                    $errors[] = TranslationAPIFacade::getInstance()->__('The requested functionality does not apply on this post.', 'pop-coreprocessors');
                }
            }
        }
    }

    protected function getRequestKey()
    {
        return POP_INPUTNAME_POSTID;
    }

    protected function additionals($target_id, $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('gd_updateusermetavalue:post', $target_id, $form_data);
        parent::additionals($target_id, $form_data);
    }
}
