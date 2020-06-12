<?php

use PoP\ComponentModel\State\ApplicationState;

class PoP_AddHighlights_Module_Processor_SectionBlocksUtils
{
    public static function addDataloadqueryargsSinglehighlights(&$ret, $post_id = null)
    {
        if (is_null($post_id)) {
            $vars = ApplicationState::getVars();
            $post_id = $vars['routing-state']['queried-object-id'];
        }

        // $ret['post-types'] = [POP_ADDHIGHLIGHTS_POSTTYPE_HIGHLIGHT];

        // Find all related posts
        $ret['meta-query'][] = [
            'key' => \PoP\CustomPostMeta\Utils::getMetaKey(GD_METAKEY_POST_HIGHLIGHTEDPOST),
            'value' => $post_id,
        ];
    }
}
