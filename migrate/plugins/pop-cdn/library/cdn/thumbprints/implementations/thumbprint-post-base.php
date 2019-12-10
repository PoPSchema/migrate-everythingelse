<?php
use PoP\LooseContracts\Facades\NameResolverFacade;

class PoP_CDN_Thumbprint_PostBase extends PoP_CDN_ThumbprintBase
{
    public function getQuery()
    {
        return array(
            'limit' => 1,
            'orderby' => NameResolverFacade::getInstance()->getName('popcms:dbcolumn:orderby:posts:modified'),
            'order' => 'DESC',
            'post-status' => POP_POSTSTATUS_PUBLISHED,
        );
    }

    public function executeQuery($query, array $options = [])
    {
        $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
        $options['return-type'] = POP_RETURNTYPE_IDS;
        return $cmspostsapi->getPosts($query, $options);
    }
    
    public function getTimestamp($post_id)
    {
        // Doing it the manual way
        $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
        $cmspostsresolver = \PoP\Posts\ObjectPropertyResolverFactory::getInstance();
        $post = $cmspostsapi->getPost($post_id);
        return mysql2date('U', $cmspostsresolver->getPostModified($post));
    }
}
