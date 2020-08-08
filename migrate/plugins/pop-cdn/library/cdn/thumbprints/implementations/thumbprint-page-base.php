<?php
use PoPSchema\Pages\Facades\PageTypeAPIFacade;
use PoP\LooseContracts\Facades\NameResolverFacade;

class PoP_CDN_Thumbprint_PageBase extends PoP_CDN_ThumbprintBase
{
    public function getQuery()
    {
        return array(
            'limit' => 1,
            'orderby' => NameResolverFacade::getInstance()->getName('popcms:dbcolumn:orderby:customposts:modified'),
            'order' => 'DESC',
            'page-status' => POP_PAGESTATUS_PUBLISHED,
        );
    }

    public function executeQuery($query, array $options = [])
    {
        $pageTypeAPI = PageTypeAPIFacade::getInstance();
        $options['return-type'] = POP_RETURNTYPE_IDS;
        return $pageTypeAPI->getPages($query, $options);
    }

    public function getTimestamp($page_id)
    {
        // Doing it the manual way
        $pageTypeAPI = PageTypeAPIFacade::getInstance();
        $cmspagesresolver = \PoPSchema\Pages\ObjectPropertyResolverFactory::getInstance();
        $page = $pageTypeAPI->getPage($page_id);
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        $cmsengineapi->getDate('U', $cmspagesresolver->getPageModified($page));
    }
}
