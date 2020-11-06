<?php

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoPSchema\CustomPosts\Facades\CustomPostTypeAPIFacade;
use PoPSchema\CustomPosts\Types\Status;
use PoPSchema\CustomPostMutations\MutationResolvers\AbstractCreateUpdateCustomPostMutationResolverBridge;

abstract class GD_DataLoad_ActionExecuter_CreateUpdate_Highlight extends AbstractCreateUpdateCustomPostMutationResolverBridge
{
    public function getSuccessString($result_id): ?string
    {
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        $status = $customPostTypeAPI->getStatus($result_id);
        if ($status == Status::PUBLISHED) {
            // Give a link to the referenced post to the stance, and force it to get it from the server again
            $highlighted = \PoPSchema\CustomPostMeta\Utils::getCustomPostMeta($result_id, GD_METAKEY_POST_HIGHLIGHTEDPOST, true);
            $success_string = sprintf(
                TranslationAPIFacade::getInstance()->__('<a href="%s" %s>Click here to view it</a>.', 'poptheme-wassup'),
                $customPostTypeAPI->getPermalink($highlighted),
                getReloadurlLinkattrs()
            );

            return HooksAPIFacade::getInstance()->applyFilters('gd-createupdate-uniquereference:execute:successstring', $success_string, $result_id, $status);
        }

        return parent::getSuccessString($result_id);
    }
}

