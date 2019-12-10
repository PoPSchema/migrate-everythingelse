<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\ModuleProcessors\Constants;
// HooksAPIFacade::getInstance()->addFilter('gd_dataload:post_types', 'gdEmAddEventPosttype');
function gdEmAddEventPosttype($post_types)
{
    $pluginapi = PoP_Events_APIFactory::getInstance();
    $post_types[] = $pluginapi->getEventPostType();
    return $post_types;
}

function eventHasCategory($event, $cat)
{
    $pluginapi = PoP_Events_APIFactory::getInstance();
    $categories = $pluginapi->getCategories($event);
    return isset($categories[$cat]);
}

// HooksAPIFacade::getInstance()->addFilter('gdGetCategories', 'gdEmGetCategories', 10, 2);
// function gdEmGetCategories($categories, $post_id)
// {
//     $pluginapi = PoP_Events_APIFactory::getInstance();
//     if ($pluginapi->isEvent($post_id)) {
//         $event = $pluginapi->getEventByPostId($post_id);
//         return array_keys($pluginapi->getCategories($event));
//     }

//     return $categories;
// }

HooksAPIFacade::getInstance()->addFilter('gd_postname', 'gdEmPostnameImpl', 10, 2);
function gdEmPostnameImpl($name, $post_id)
{
    $pluginapi = PoP_Events_APIFactory::getInstance();
    if ($pluginapi->isEvent($post_id)) {
        return TranslationAPIFacade::getInstance()->__('Event', 'poptheme-wassup');
    }

    return $name;
}
HooksAPIFacade::getInstance()->addFilter('gd_posticon', 'gdEmPosticonImpl', 10, 2);
function gdEmPosticonImpl($icon, $post_id)
{
    $pluginapi = PoP_Events_APIFactory::getInstance();
    if ($pluginapi->isEvent($post_id)) {
        return getRouteIcon(POP_EVENTS_ROUTE_EVENTS, false);
    }

    return $icon;
}

HooksAPIFacade::getInstance()->addFilter(
    Constants::HOOK_QUERYDATA_WHITELISTEDPARAMS, 
    function($params) {
        $params[] = GD_URLPARAM_YEAR;
        $params[] = GD_URLPARAM_MONTH;
        return $params;
    }
);
