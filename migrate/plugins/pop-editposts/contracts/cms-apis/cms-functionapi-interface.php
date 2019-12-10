<?php
namespace PoP\EditPosts;

interface FunctionAPI
{
    public function getEditPostLink($post_id);
    public function getDeletePostLink($post_id);
    public function insertPost($post_data);
    public function updatePost($post_data);
    public function getPostEditorContent($post_id);
    public function getAllowedPostTags();
}
