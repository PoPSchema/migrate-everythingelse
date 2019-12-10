<?php

class UserStance_Module_Processor_CustomSectionBlocksUtils
{
    public static function addDataloadqueryargsStancesaboutpost(&$ret, $referenced_post_id)
    {
        $ret['meta-query'][] = [
            'key' => \PoP\PostMeta\Utils::getMetaKey(GD_METAKEY_POST_STANCETARGET),
            'value' => $referenced_post_id,
        ];
        $ret['post-types'] = [POP_USERSTANCE_POSTTYPE_USERSTANCE];
        // $ret['fields'] = 'ids';
    }

    public static function addDataloadqueryargsGeneralstances(&$ret)
    {
        $ret['meta-query'][] = [
            'key' => \PoP\PostMeta\Utils::getMetaKey(GD_METAKEY_POST_STANCETARGET),
            'compare' => 'NOT EXISTS',
        ];
        $ret['post-types'] = [POP_USERSTANCE_POSTTYPE_USERSTANCE];
        // $ret['fields'] = 'ids';
    }

    public static function addDataloadqueryargsPoststances(&$ret)
    {

        // All results where there is an article involved
        $ret['meta-query'][] = [
            'key' => \PoP\PostMeta\Utils::getMetaKey(GD_METAKEY_POST_STANCETARGET),
            'compare' => 'EXISTS',
        ];
        $ret['post-types'] = [POP_USERSTANCE_POSTTYPE_USERSTANCE];
        // $ret['fields'] = 'ids';
    }

    public static function addDataloadqueryargsSinglestances(&$ret, $referenced_post_id = null)
    {
        if (!$referenced_post_id) {
            $vars = \PoP\ComponentModel\Engine_Vars::getVars();
            $referenced_post_id = $vars['routing-state']['queried-object-id'];
        }

        $ret['post-types'] = [POP_USERSTANCE_POSTTYPE_USERSTANCE];

        // Find all related posts
        $ret['meta-query'][] = [
            'key' => \PoP\PostMeta\Utils::getMetaKey(GD_METAKEY_POST_STANCETARGET),
            'value' => $referenced_post_id,
        ];
    }
}
