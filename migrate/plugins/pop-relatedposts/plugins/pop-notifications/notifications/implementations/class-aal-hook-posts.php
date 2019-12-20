<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


// By not expending from class AAL_Hook_Base, this code is de-attached from AAL
class PoP_RelatedPosts_Notifications_Hook_Posts /* extends AAL_Hook_Base*/
{
    public function __construct()
    {
        
        // Referenced Post
        HooksAPIFacade::getInstance()->addAction(
            'gd_createupdate_post:create',
            array($this, 'createdPostRelatedToPost')
        );
        HooksAPIFacade::getInstance()->addAction(
            'gd_createupdate_post:update',
            array($this, 'updatedPostRelatedToPost'),
            10,
            2
        );
    }

    public function createdPostRelatedToPost($post_id)
    {
        $cmspostsapi = PostTypeAPIFacade::getInstance();
        $cmsapplicationpostsapi = \PoP\Application\PostsFunctionAPIFactory::getInstance();
        if (in_array($cmspostsapi->getPostType($post_id), $cmsapplicationpostsapi->getAllcontentPostTypes())) {
            if ($cmspostsapi->getPostStatus($post_id) == POP_POSTSTATUS_PUBLISHED) {
                // Referenced posts: all of them for the new post
                $references = \PoP\PostMeta\Utils::getPostMeta($post_id, GD_METAKEY_POST_REFERENCES);
                $this->relatedToPost($post_id, $references);
            }
        }
    }

    public function updatedPostRelatedToPost($post_id, $log)
    {
        $cmspostsapi = PostTypeAPIFacade::getInstance();
        $cmsapplicationpostsapi = \PoP\Application\PostsFunctionAPIFactory::getInstance();
        if (in_array($cmspostsapi->getPostType($post_id), $cmsapplicationpostsapi->getAllcontentPostTypes())) {
            if ($cmspostsapi->getPostStatus($post_id) == POP_POSTSTATUS_PUBLISHED) {
                // Referenced posts: if doing an update, pass only the newly added ones
                // If doing a create (changed "draft" to "publish"), then add all references
                if ($log['previous-status'] != POP_POSTSTATUS_PUBLISHED) {
                    // This is a Create post
                    $references = \PoP\PostMeta\Utils::getPostMeta($post_id, GD_METAKEY_POST_REFERENCES);
                } else {
                    // This is an Update post
                    $references = $log['new-references'];
                }
                $this->relatedToPost($post_id, $references);
            }
        }
    }

    protected function relatedToPost($post_id, $references)
    {
        
        // Referenced posts
        if ($references) {
            $cmspostsapi = PostTypeAPIFacade::getInstance();
            $cmspostsresolver = \PoP\Posts\ObjectPropertyResolverFactory::getInstance();
            $post = $cmspostsapi->getPost($post_id);
            foreach ($references as $reference_id) {
                PoP_Notifications_Utils::insertLog(
                    array(
                        'user_id' => $cmspostsresolver->getPostAuthor($post),
                        'action' => AAL_POP_ACTION_POST_REFERENCEDPOST,
                        'object_type' => 'Post',
                        'object_subtype' => $cmspostsapi->getPostType($reference_id),
                        'object_id' => $reference_id,
                        'object_name' => $cmspostsapi->getTitle($reference_id),
                    )
                );
            }
        }
    }
}
