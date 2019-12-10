<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_Application_Engine_Vars
{
    public static function addVars($vars_in_array)
    {
        $vars = &$vars_in_array[0];
        if ($timestamp = $_REQUEST[GD_URLPARAM_TIMESTAMP]) {
            $vars['timestamp'] = (int) $timestamp;
        }

        $vars['loading-latest'] = 
        	in_array(GD_URLPARAM_ACTION_LOADLATEST, $vars['actions'])  && 
	        // Also make sure a timestamp was passed along
        	isset($vars['timestamp']) &&
        	// Only for allowed routes, such as notifications (avoid calling the homepage with "loading-latest" or the amount of retrieved data can bring the server down)
        	in_array(
        		$vars['route'],
        		HooksAPIFacade::getInstance()->applyFilters(
        			'loadingLatestRoutes',
        			[]
        		)
        	)
        ;
    }
}

/**
 * Initialization
 */
HooksAPIFacade::getInstance()->addAction('\PoP\ComponentModel\Engine_Vars:addVars', array(PoP_Application_Engine_Vars::class, 'addVars'), 10, 1);
