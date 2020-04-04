<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;

class PoP_URE_Engine_Hooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addAction(
            'ApplicationState:addVars', 
            [$this, 'addVars'], 
            10,
            1
        );
        HooksAPIFacade::getInstance()->addAction(
            'augmentVarsProperties', 
            [$this, 'augmentVarsProperties'], 
            10,
            1
        );
    }
    public function addVars($vars_in_array)
    {
        $vars = &$vars_in_array[0];
        if ($vars['nature'] == UserRouteNatures::USER) {
            $author = $vars['routing-state']['queried-object-id'];
            if (gdUreIsCommunity($author)) {
                $source = $_REQUEST[GD_URLPARAM_URECONTENTSOURCE];
                $sources = array(
                    GD_URLPARAM_URECONTENTSOURCE_USER,
                    GD_URLPARAM_URECONTENTSOURCE_COMMUNITY,
                );
                if (!in_array($source, $sources)) {
                    $source = gdUreGetDefaultContentsource();
                }
                
                $vars['source'] = $source;
            }
        }
    }

    public function augmentVarsProperties($vars_in_array)
    {
        $vars = &$vars_in_array[0];
        if ($vars['nature'] == UserRouteNatures::USER) {
            $author = $vars['routing-state']['queried-object-id'];
            $vars['routing-state']['queried-object-is-community'] = gdUreIsCommunity($author);
        }
    }
}

/**
 * Initialization
 */
new PoP_URE_Engine_Hooks();
