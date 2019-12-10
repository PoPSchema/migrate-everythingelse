<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_MultiDomain_ResourceLoader_FileReproduction_Config extends PoP_MultiDomain_ResourceLoader_FileReproductionBase
{
    public function getAssetsPath()
    {
        
        // return POP_MULTIDOMAINSPARESOURCELOADER_ASSETS_DIR.'/js/jobs/multidomain-resourceloader-config.js';
        return dirname(dirname(__FILE__)) .'/assets/js/jobs/multidomain-resourceloader-config.js';
    }
    
    public function getConfiguration()
    {
        $configuration = parent::getConfiguration();

        // Domain
        $configuration['$resourceLoaderSources'] = HooksAPIFacade::getInstance()->applyFilters(
            'PoP_MultiDomain_ResourceLoader_FileReproduction_Config:resourceloader-config:sources',
            array()
        );

        return $configuration;
    }
}
    
