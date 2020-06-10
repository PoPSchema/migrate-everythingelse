<?php
use PoP\LooseContracts\Facades\NameResolverFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;
use PoP\Content\Types\Status;

class PoP_CDN_Thumbprint_PostBase extends PoP_CDN_ThumbprintBase
{
    public function getQuery()
    {
        return array(
            'limit' => 1,
            'orderby' => NameResolverFacade::getInstance()->getName('popcms:dbcolumn:orderby:posts:modified'),
            'order' => 'DESC',
            'post-status' => Status::PUBLISHED,
        );
    }

    public function executeQuery($query, array $options = [])
    {
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        $options['return-type'] = POP_RETURNTYPE_IDS;
        return $postTypeAPI->getPosts($query, $options);
    }

    public function getTimestamp($post_id)
    {
        // Doing it the manual way
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        $cmsengineapi->getDate('U', $postTypeAPI->getModifiedDate($post_id));
    }
}
