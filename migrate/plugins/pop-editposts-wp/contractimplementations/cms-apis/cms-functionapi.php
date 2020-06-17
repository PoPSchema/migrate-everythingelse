<?php

namespace PoP\EditPosts\WP;

use PoP\CustomPostsWP\TypeAPIs\CustomPostTypeAPIUtils;

class FunctionAPI extends \PoP\EditPosts\FunctionAPI_Base
{
    public function getEditPostLink($post_id)
    {
        return get_edit_post_link($post_id);
    }
    public function getDeletePostLink($post_id)
    {
        return get_delete_post_link($post_id);
    }
    protected function convertQueryArgsFromPoPToCMSForInsertUpdatePost(&$query)
    {
        // Convert the parameters
        if (isset($query['post-status'])) {
            $query['post_status'] = CustomPostTypeAPIUtils::convertPostStatusFromPoPToCMS($query['post-status']);
            unset($query['post-status']);
        }
        if (isset($query['id'])) {
            $query['ID'] = $query['id'];
            unset($query['id']);
        }
        if (isset($query['post-content'])) {
            $query['post_content'] = $query['post-content'];
            unset($query['post-content']);
        }
        if (isset($query['post-title'])) {
            $query['post_title'] = $query['post-title'];
            unset($query['post-title']);
        }
        if (isset($query['post-categories'])) {
            $query['post_category'] = $query['post-categories'];
            unset($query['post-categories']);
        }
        if (isset($query['post-type'])) {
            $query['post_type'] = $query['post-type'];
            unset($query['post-type']);
        }
    }
    public function insertPost($post_data)
    {
        // Convert the parameters
        $this->convertQueryArgsFromPoPToCMSForInsertUpdatePost($post_data);
        return wp_insert_post($post_data);
    }
    public function updatePost($post_data)
    {
        // Convert the parameters
        $this->convertQueryArgsFromPoPToCMSForInsertUpdatePost($post_data);
        return wp_update_post($post_data);
    }
    public function getPostEditorContent($post_id)
    {
        $post = get_post($post_id);
        return apply_filters('the_editor_content', $post->post_content);
    }
    public function getAllowedPostTags()
    {
        global $allowedposttags;
        return $allowedposttags;
    }
}

/**
 * Initialize
 */
new FunctionAPI();
