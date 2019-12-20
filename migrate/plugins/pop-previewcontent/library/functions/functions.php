<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

HooksAPIFacade::getInstance()->addFilter('gd-createupdate-post:execute:successstring', 'gdPppCreateupdateAddPreviewLink', 10, 3);
function gdPppCreateupdateAddPreviewLink($success_string, $post_id, $status)
{
    if (in_array($status, array(POP_POSTSTATUS_DRAFT, POP_POSTSTATUS_PENDING))) {
        $pluginapi = PoP_PreviewContent_FunctionsAPIFactory::getInstance();
        $previewurl = $pluginapi->getPreviewLink($post_id);

        // Allow to inject data-sw-networkfirst="true"
        $previewurl_params = HooksAPIFacade::getInstance()->applyFilters('gd_ppp_previewurl_link_params', '');
        if ($previewurl) {
            $previewurl_target = HooksAPIFacade::getInstance()->applyFilters('gd_ppp_previewurl_target', POP_TARGET_MAIN);
            $success_string .= sprintf(
                ' <a href="%1$s" target="%2$s" class="btn btn-xs btn-primary" %4$s><i class="fa fa-fw fa-eye"></i>%3$s</a>',
                $previewurl,
                $previewurl_target,
                TranslationAPIFacade::getInstance()->__('Preview', 'ppp-pop'),
                $previewurl_params
            );
        }
    }

    return $success_string;
}

HooksAPIFacade::getInstance()->addFilter('gd_createupdate_post', 'gdPppAddPublicPreview', 10, 1);
function gdPppAddPublicPreview($post_id)
{
    $postTypeAPI = PostTypeAPIFacade::getInstance();
    $post_status = $postTypeAPI->getStatus($post_id);
    if (in_array($post_status, array(POP_POSTSTATUS_DRAFT, POP_POSTSTATUS_PENDING, POP_POSTSTATUS_PUBLISHED))) {
        $pluginapi = PoP_PreviewContent_FunctionsAPIFactory::getInstance();

        // Add the post to have "public preview"
        if (in_array($post_status, array(POP_POSTSTATUS_DRAFT, POP_POSTSTATUS_PENDING))) {
            $pluginapi->setPreview($post_id);
        }
        // Remove it, so published posts don't have the "public preview" enabled anymore
        elseif (($post_status == POP_POSTSTATUS_PUBLISHED)) {
            $pluginapi->removePreview($post_id);
        }
    }
}
