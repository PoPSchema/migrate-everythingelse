<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_MultiDomain_InitDomainScripts_Config extends \PoP\FileStore\File\AbstractRenderableFileFragment
{
    public function getAssetsPath()
    {
        return dirname(__FILE__).'/assets/js/multidomain-domainscripts.js';
    }

    // public function getRenderer()
    // {
    //     global $pop_multidomain_initdomainscripts_filerenderer;
    //     return $pop_multidomain_initdomainscripts_filerenderer;
    // }
    
    public function getConfiguration()
    {
        $configuration = parent::getConfiguration();

        // Domain
        $configuration['$domainScripts'] = HooksAPIFacade::getInstance()->applyFilters(
            'PoP_MultiDomain_InitDomainScripts_Config:domain-scripts',
            array()
        );

        return $configuration;
    }
}
    
