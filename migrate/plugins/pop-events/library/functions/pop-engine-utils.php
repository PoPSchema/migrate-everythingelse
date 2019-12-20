<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Routing\RouteNatures as PostRouteNatures;
use PoP\Posts\Facades\PostTypeAPIFacade;
use PoP\Events\FacadesEventTypeAPIFacade;

class PoP_Events_Engine_Hooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addAction(
            'augmentVarsProperties',
            [$this, 'augmentVarsProperties'],
            10,
            1
        );
    }

    public function augmentVarsProperties($vars_in_array)
    {

        // Set additional properties based on the nature: the global $post, $author, or $queried_object
        $vars = &$vars_in_array[0];
        $nature = $vars['nature'];

        // Attributes needed to match the RouteModuleProcessor vars conditions
        if ($nature == PostRouteNatures::POST) {
            $postTypeAPI = PostTypeAPIFacade::getInstance();
            $eventTypeAPI = EventTypeAPIFacade::getInstance();
            $post_id = $vars['routing-state']['queried-object-id'];
            if ($postTypeAPI->getPostType($post_id) == $eventTypeAPI->getEventPostType()) {
                if ($eventTypeAPI->isFutureEvent($post_id)) {
                    $vars['routing-state']['queried-object-is-future-event'] = true;
                } elseif ($eventTypeAPI->isCurrentEvent($post_id)) {
                    $vars['routing-state']['queried-object-is-current-event'] = true;
                } elseif ($eventTypeAPI->isPastEvent($post_id)) {
                    $vars['routing-state']['queried-object-is-past-event'] = true;
                }
            }
        }
    }
}

/**
 * Initialization
 */
new PoP_Events_Engine_Hooks();
