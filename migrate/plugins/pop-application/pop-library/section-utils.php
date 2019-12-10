<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_Application_SectionUtils
{
    public static function addDataloadqueryargsLatestcounts(&$ret)
    {
        self::addDataloadqueryargsAllcontent($ret);

        // Allow Non-All Content blocks to also add their data
        HooksAPIFacade::getInstance()->doAction(
            'PoP_Application_SectionUtils:dataloadqueryargs-latestcounts',
            array(&$ret)
        );
    }

    public static function addDataloadqueryargsAllcontent(&$ret)
    {
        $cmsapplicationpostsapi = \PoP\Application\PostsFunctionAPIFactory::getInstance();
        if ($post_types = $cmsapplicationpostsapi->getAllcontentPostTypes()) {
            $ret['post-types'] = $post_types;
        }

        // Allow WordPress to add the 'tax-query' items
        HooksAPIFacade::getInstance()->doAction(
            'PoP_Application_SectionUtils:dataloadqueryargs-allcontent',
            array(&$ret)
        );
    }

    public static function addDataloadqueryargsAllcontentBysingletag(&$ret)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $cmsapplicationpostsapi = \PoP\Application\PostsFunctionAPIFactory::getInstance();
        $tag_id = $vars['routing-state']['queried-object-id'];
        $ret['tag-ids'] = [$tag_id];
        $ret['post-types'] = $cmsapplicationpostsapi->getAllcontentPostTypes();

        // Allow WordPress to add the 'tax-query' items
        HooksAPIFacade::getInstance()->doAction(
            'PoP_Application_SectionUtils:dataloadqueryargs-allcontent-bysingletag',
            array(&$ret)
        );
    }
}