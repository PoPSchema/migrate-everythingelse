<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Engine\Route\RouteUtils;

/**
 * Section Filters
 */
HooksAPIFacade::getInstance()->addFilter('wassup_section_taxonomyterms', 'popEmSectionTaxonomyterms', 0);
function popEmSectionTaxonomyterms($section_taxonomyterms)
{
    if (POP_EVENTS_CAT_ALL) {
        $pluginapi = PoP_Events_APIFactory::getInstance();
        $section_taxonomyterms = array_merge_recursive(
            $section_taxonomyterms,
            array(
                $pluginapi->getEventCategoryTaxonomy() => array(
                    POP_EVENTS_CAT_ALL,
                ),
            )
        );
    }

    return $section_taxonomyterms;
}

HooksAPIFacade::getInstance()->addFilter('GD_FormInput_ContentSections:taxonomyterms:name', 'popEmSectionTaxonomytermsName', 10, 3);
function popEmSectionTaxonomytermsName($name, $taxonomy, $term)
{
    if (POP_EVENTS_ROUTE_EVENTS) {
        $pluginapi = PoP_Events_APIFactory::getInstance();
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        if ($taxonomy == $pluginapi->getEventCategoryTaxonomy()) {
            return RouteUtils::getRouteTitle(POP_EVENTS_ROUTE_EVENTS);
        }
    }

    return $name;
}
