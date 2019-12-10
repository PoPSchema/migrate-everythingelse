<?php
use PoP\Hooks\Facades\HooksAPIFacade;

/**
 * Integration with Latest Everything Block
 */
HooksAPIFacade::getInstance()->addFilter('pop_module:allcontent:tax_query_items', 'popEmAllcontentTaxqueryItems');
function popEmAllcontentTaxqueryItems($tax_query_items)
{
    if (POP_EVENTS_CAT_ALL) {
        $pluginapi = PoP_Events_APIFactory::getInstance();
        $cmsapplicationpostsapi = \PoP\Application\PostsFunctionAPIFactory::getInstance();
        if (in_array($pluginapi->getEventPostType(), $cmsapplicationpostsapi->getAllcontentPostTypes())) {
            $tax_query_items[] = array(
                'taxonomy' => $pluginapi->getEventCategoryTaxonomy(),
                'terms' => array(
                    POP_EVENTS_CAT_ALL,
                ),
            );
        }
    }

    return $tax_query_items;
}
