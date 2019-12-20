<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

HooksAPIFacade::getInstance()->addFilter('popcms:post:title', 'maybeGetTitleAsBasicContent', 10, 2);
function maybeGetTitleAsBasicContent($title, $post_id = null)
{
    $post_types = HooksAPIFacade::getInstance()->applyFilters(
        'get_title_as_basic_content:post_types',
        array()
    );
    $postTypeAPI = PostTypeAPIFacade::getInstance();
    if (in_array($postTypeAPI->getPostType($post_id), $post_types)) {
        return limitString($postTypeAPI->getBasicPostContent($post_id), 100);
    }

    return $title;
}
