<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

// Event and Past Event have different configurations, so we must differentiate among them
HooksAPIFacade::getInstance()->addFilter(\PoP\ComponentModel\ModelInstance\ModelInstance::HOOK_COMPONENTS_RESULT, 'popEmModuleInstanceComponents');
function popEmModuleInstanceComponents($components)
{

    // Add source param for Organizations: view their profile as Community or Organization
    $vars = \PoP\ComponentModel\Engine_Vars::getVars();
    if ($vars['routing-state']['is-post']) {
        $post_id = $vars['routing-state']['queried-object-id'];
        $pluginapi = PoP_Events_APIFactory::getInstance();
        if ($pluginapi->isEvent($post_id)) {
            $components[] = TranslationAPIFacade::getInstance()->__('event scope:', 'pop-events').($pluginapi->isFutureEvent($post_id) ? 'future' : ($pluginapi->isCurrentEvent($post_id) ? 'current' : 'past'));
        }
    }

    return $components;
}

HooksAPIFacade::getInstance()->addFilter('ModelInstanceProcessor:getCategories', 'gdEmModelinstanceGetCategories', 10, 2);
function gdEmModelinstanceGetCategories($cats, $post_id)
{
    $pluginapi = PoP_Events_APIFactory::getInstance();
    if ($pluginapi->isEvent($post_id)) {
        $event = $pluginapi->getEventByPostId($post_id);
        $cmstaxonomiesresolver = \PoP\Taxonomies\ObjectPropertyResolverFactory::getInstance();
        foreach ($pluginapi->getCategories($event) as $cat) {
            // Watch out: $cat is of type EM_TAXONOMY_CATEGORY, so to query the slug and ID we may need to use its own function "output",
            // on which case we should place it under the $pluginapi.
            // However because these inner variables are just ->slug and ->term_id (same as normal category), then we assume this is the standard case,
            // and access them directly
            // $cat_slug = $cat->output('#_CATEGORYSLUG');
            // $cat_id = $cat->output('#_CATEGORYID');
            $cats[] = $cmstaxonomiesresolver->getCategorySlug($cat).$cmstaxonomiesresolver->getCategoryId($cat);
        }
    }

    return $cats;
}
