<?php

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoPSchema\CustomPosts\Facades\CustomPostTypeAPIFacade;
use PoPSchema\CustomPosts\Types\Status;

class GD_DataLoad_ActionExecuter_CreateUpdate_Highlight extends GD_DataLoad_ActionExecuter_CreateUpdate_PostBase
{
    public function getCreateupdate()
    {
        return new GD_CreateUpdate_Highlight();
    }

    public function getSuccessString($post_id, $status)
    {
        if ($status == Status::PUBLISHED) {
            $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
            // Give a link to the referenced post to the stance, and force it to get it from the server again
            $highlighted = \PoPSchema\CustomPostMeta\Utils::getCustomPostMeta($post_id, GD_METAKEY_POST_HIGHLIGHTEDPOST, true);
            $success_string = sprintf(
                TranslationAPIFacade::getInstance()->__('<a href="%s" %s>Click here to view it</a>.', 'poptheme-wassup'),
                $customPostTypeAPI->getPermalink($highlighted),
                getReloadurlLinkattrs()
            );

            return HooksAPIFacade::getInstance()->applyFilters('gd-createupdate-uniquereference:execute:successstring', $success_string, $post_id, $status);
        }

        return parent::getSuccessString($post_id, $status);
    }
}

