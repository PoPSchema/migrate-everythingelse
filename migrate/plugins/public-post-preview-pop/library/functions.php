<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

// Complement to the plugin: also save_post when in webplatform
if (!is_admin()) {
    HooksAPIFacade::getInstance()->addAction('save_post', array('DS_Public_Post_Preview', 'register_public_preview'), 20, 2);
}

function gdPppPreviewLink($post_id)
{

    // Check if preview enabled for this post
    $preview_post_ids = DS_Public_Post_Preview::get_preview_post_ids();
    if (in_array($post_id, $preview_post_ids)) {
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        return DS_Public_Post_Preview::get_preview_link($postTypeAPI->getPost($post_id));
    }

    return null;
}
