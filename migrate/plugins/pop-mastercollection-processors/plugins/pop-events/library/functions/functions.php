<?php
use PoP\Hooks\Facades\HooksAPIFacade;

// HooksAPIFacade::getInstance()->addFilter('gdPostParentpageid', 'gdEmPostParentpageidImpl', 10, 2);
// function gdEmPostParentpageidImpl($pageid, $post_id)
// {
//     $pluginapi = PoP_Events_APIFactory::getInstance();
//     if ($pluginapi->isEvent($post_id)) {
//         if ($pluginapi->isFutureEvent($post_id)) {
//             return POP_EVENTS_ROUTE_EVENTS;
//         }
//         return POP_EVENTS_ROUTE_PASTEVENTS;
//     }

//     return $pageid;
// }
