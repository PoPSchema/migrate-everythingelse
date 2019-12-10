<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Modules\ModuleUtils;
 
class PoP_CoreProcessors_CDN_Hooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'PoP_CDN_FileReproduction_ThumbprintsConfig:criteriaitems:thumbprint:hasParamValues',
            array($this, 'getThumbprintParamvalues'),
            10,
            2
        );
    }

    public function getThumbprintParamvalues($paramvalues, $thumbprint)
    {
        if ($thumbprint == POP_CDN_THUMBPRINT_COMMENT) {
            // Fetch the comments through lazy-load when calling POP_POSTS_ROUTE_LOADERS_POSTS_LAYOUTS
            // eg: https://www.mesym.com/en/loaders/posts/layouts/?pid[0]=21537&layouts[0]=highrefby-fullview&layouts[1]=refby-fullview&layouts[2]=postcomments&format=requestlayouts&target=main&module=settingsdata&output=json&theme=wassup&thememode=sliding&themestyle=swift
            $module = [PoP_Module_Processor_CommentsWrappers::class, PoP_Module_Processor_CommentsWrappers::MODULE_WIDGETWRAPPER_POSTCOMMENTS_APPENDTOSCRIPT];
            $paramvalues[] = array(
                GD_URLPARAM_LAYOUTS,
                ModuleUtils::getModuleFullName($module)
            );
        }
        
        return $paramvalues;
    }
}
    
/**
 * Initialize
 */
new PoP_CoreProcessors_CDN_Hooks();
