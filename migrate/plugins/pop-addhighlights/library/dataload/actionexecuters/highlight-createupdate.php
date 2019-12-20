<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

class GD_DataLoad_ActionExecuter_CreateUpdate_Highlight extends GD_DataLoad_ActionExecuter_CreateUpdate_PostBase
{
    public function getCreateupdate()
    {
        return new GD_CreateUpdate_Highlight();
    }

    public function getSuccessString($post_id, $status)
    {
        if ($status == POP_POSTSTATUS_PUBLISHED) {
            $cmspostsapi = PostTypeAPIFacade::getInstance();
            // Give a link to the referenced post to the stance, and force it to get it from the server again
            $highlighted = \PoP\PostMeta\Utils::getPostMeta($post_id, GD_METAKEY_POST_HIGHLIGHTEDPOST, true);
            $success_string = sprintf(
                TranslationAPIFacade::getInstance()->__('<a href="%s" %s>Click here to view it</a>.', 'poptheme-wassup'),
                $cmspostsapi->getPermalink($highlighted),
                getReloadurlLinkattrs()
            );

            return HooksAPIFacade::getInstance()->applyFilters('gd-createupdate-uniquereference:execute:successstring', $success_string, $post_id, $status);
        }

        return parent::getSuccessString($post_id, $status);
    }
}
    
