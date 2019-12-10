<?php
class PoP_MultiDomain_CDN_ConfigFile extends \PoP\FileStore\File\AbstractAccessibleRenderableFile
{
    public function getDir()
    {
        return POP_MULTIDOMAIN_CONTENT_DIR;
    }
    public function getUrl()
    {
        return POP_MULTIDOMAIN_CONTENT_URL;
    }

    public function getFilename()
    {
        return 'multidomain-domainscripts.js';
    }

    // public function getRenderer()
    // {
    //     global $pop_multidomain_initdomainscripts_filerenderer;
    //     return $pop_multidomain_initdomainscripts_filerenderer;
    // }
    protected function getFragmentObjects(): array
    {
        return [
            new PoP_MultiDomain_InitDomainScripts_Config(),
        ];
    }
}
    
/**
 * Initialize
 */
global $pop_multidomain_initdomainscripts_configfile;
$pop_multidomain_initdomainscripts_configfile = new PoP_MultiDomain_CDN_ConfigFile();
