<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_AddComments_SocialNetwork_DataLoad_TypeResolver_Notifications_Hook
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'PoP_AddComments_DataLoad_TypeResolver_Notifications_Hook:comment-added:message',
            array($this, 'getMessage'),
            10,
            2
        );
    }

    public function getMessage($message, $notification)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $user_id = $vars['global-userstate']['current-user-id'];
        $cmscommentsapi = \PoP\Comments\FunctionAPIFactory::getInstance();
        $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();
        $cmstaxonomiesresolver = \PoP\Taxonomies\ObjectPropertyResolverFactory::getInstance();
        $cmscommentsresolver = \PoP\Comments\ObjectPropertyResolverFactory::getInstance();
        $comment = $cmscommentsapi->getComment($notification->object_id);

        // If the user has been tagged in this comment, this action has higher priority than commenting, then show that message
        $taggedusers_ids = \PoP\CommentMeta\Utils::getCommentMeta($cmscommentsresolver->getCommentId($comment), GD_METAKEY_COMMENT_TAGGEDUSERS);
        if (in_array($user_id, $taggedusers_ids)) {
            $message = TranslationAPIFacade::getInstance()->__('<strong>%1$s</strong> mentioned you in a comment in %2$s <strong>%3$s</strong>', 'pop-notifications');
        }
        // If the comment has #hashtags the user is subscribed to, then add it as part of the message (the notification may appear only because of the #hashtag)
        elseif ($comment_tags = \PoP\CommentMeta\Utils::getCommentMeta($cmscommentsresolver->getCommentId($comment), GD_METAKEY_COMMENT_TAGS)) {
            $user_hashtags = \PoP\UserMeta\Utils::getUserMeta($user_id, GD_METAKEY_PROFILE_SUBSCRIBESTOTAGS);
            if ($intersected_tags = array_values(array_intersect($comment_tags, $user_hashtags))) {
                $tags = array();
                foreach ($intersected_tags as $tag_id) {
                    $tag = $taxonomyapi->getTag($tag_id);
                    $tags[] = $cmstaxonomiesresolver->getTagSymbolName($tag);
                }
                $message = sprintf(
                    TranslationAPIFacade::getInstance()->__('%1$s (<em>tags: <strong>%2$s</strong></em>)', 'pop-notifications'),
                    $message,
                    implode(TranslationAPIFacade::getInstance()->__(', ', 'pop-notifications'), $tags)
                );
            }
        }

        return $message;
    }
}
    
/**
 * Initialize
 */
new PoP_AddComments_SocialNetwork_DataLoad_TypeResolver_Notifications_Hook();
