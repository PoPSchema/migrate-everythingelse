<?php
use PoP\Posts\Facades\PostTypeAPIFacade;
use PoP\ComponentModel\State\ApplicationState;

class PoP_RelatedPosts_SectionUtils
{
    public static function addDataloadqueryargsReferences(&$ret, $post_id = null): void
    {
        // Set it for 'All Content' (eg: exclude Highlights, which also use references but are a special case)
        // PoP_Application_SectionUtils::addDataloadqueryargsAllcontent($ret);
        PoP_Application_SectionUtils::addDataloadqueryargsAllcontent($ret);

        if (is_null($post_id)) {
            $vars = ApplicationState::getVars();
            $post_id = $vars['routing-state']['queried-object-id'];
        }

        // Find all related posts
        $ret['meta-query'][] = [
            'key' => \PoP\CustomPostMeta\Utils::getMetaKey(GD_METAKEY_POST_REFERENCES),
            'value' => array($post_id),
            'compare' => 'IN'
        ];
    }

    public static function getReferencedby($post_id): array
    {
        // Build the query args from the Utils
        $query = [
            'limit'/*'posts-per-page'*/ => -1, // Bring all the results
        ];
        self::addDataloadqueryargsReferences($query, $post_id);

        $postTypeAPI = PostTypeAPIFacade::getInstance();
        return $postTypeAPI->getPosts($query, ['return-type' => POP_RETURNTYPE_IDS]);
    }
}
