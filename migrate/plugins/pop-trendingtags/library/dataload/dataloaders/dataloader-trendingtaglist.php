<?php
namespace PoP\TrendingTags;
use PoP\Taxonomies\TypeDataResolvers\TagTypeDataResolver;

class TrendingTagList extends TagTypeDataResolver
{
    public function getQuery($query_args): array
    {
        $query = parent::getQuery($query_args);

        // $days = $query_args['days'];
        // $query['days'] = $days ? intval($days) : POP_TRENDINGTAGS_DAYS_TRENDINGTAGS;
        // One Week by default for the trending topics
        if (!$query['days']) {
            $query['days'] = POP_TRENDINGTAGS_DAYS_TRENDINGTAGS;
        }
        
        return $query;
    }
    
    public function executeQueryIds($query): array
    {
        $cmstrendingtagsapi = FunctionAPIFactory::getInstance();
        return $cmstrendingtagsapi->getTrendingHashtagIds($query['days'], $query['limit'], $query['offset']);
    }
}
