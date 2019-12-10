<?php
use PoP\Hooks\Facades\HooksAPIFacade;

//-------------------------------------------------------------------------------------
// Load Plugin-specific Libraries
//-------------------------------------------------------------------------------------

// Add the Events and Locations for the resourceLoader single path configuration
HooksAPIFacade::getInstance()->addFilter('PoP_ResourceLoader_FileReproduction_Config:configuration:category-paths', 'emPopResourceloaderSinglePaths');
function emPopResourceloaderSinglePaths($paths)
{
    $pluginapi = PoP_Events_APIFactory::getInstance();
    $paths[] = $pluginapi->getEventPostTypeSlug().'/';
    return $paths;
}
