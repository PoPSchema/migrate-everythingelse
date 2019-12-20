<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


// By not expending from class AAL_Hook_Base, this code is de-attached from AAL
class PoP_AddHighlights_Notifications_Hook_Posts /* extends AAL_Hook_Base*/
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addAction(
            'GD_CreateUpdate_Highlight:createadditionals',
            array($this, 'createdHighlight')
        );
        HooksAPIFacade::getInstance()->addAction(
            'GD_CreateUpdate_Highlight:updateadditionals',
            array($this, 'updatedHighlight'),
            10,
            3
        );
    }

    public function createdHighlight($post_id)
    {
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        if ($postTypeAPI->getPostStatus($post_id) == POP_POSTSTATUS_PUBLISHED) {
            $referenced_post_id = \PoP\PostMeta\Utils::getPostMeta($post_id, GD_METAKEY_POST_HIGHLIGHTEDPOST, true);
            $this->referencedPost($post_id, $referenced_post_id);
        }
    }

    public function updatedHighlight($post_id, $form_data, $log)
    {
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        if ($postTypeAPI->getPostStatus($post_id) == POP_POSTSTATUS_PUBLISHED) {
            // If doing a create (changed "draft" to "publish"), then add all references
            if ($log['previous-status'] != POP_POSTSTATUS_PUBLISHED) {
                $referenced_post_id = \PoP\PostMeta\Utils::getPostMeta($post_id, GD_METAKEY_POST_HIGHLIGHTEDPOST, true);
                $this->referencedPost($post_id, $referenced_post_id);
            }
        }
    }

    protected function referencedPost($post_id, $referenced_post_id)
    {
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        $cmspostsresolver = \PoP\Posts\ObjectPropertyResolverFactory::getInstance();
        $post = $postTypeAPI->getPost($post_id);
        PoP_Notifications_Utils::insertLog(
            array(
                'user_id' => $cmspostsresolver->getPostAuthor($post),
                'action' => AAL_POP_ACTION_POST_HIGHLIGHTEDFROMPOST,
                'object_type' => 'Post',
                'object_subtype' => $postTypeAPI->getPostType($referenced_post_id),
                'object_id' => $referenced_post_id,
                'object_name' => $postTypeAPI->getTitle($referenced_post_id),
            )
        );
    }
}
