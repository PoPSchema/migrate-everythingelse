<?php
class PoP_MultiDomain_ResourceLoader_ConfigFile extends \PoP\FileStore\File\AbstractAccessibleRenderableFile
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
        return 'multidomain-resourceloader-config.js';
    }

    // public function getRenderer()
    // {
    //     global $pop_multidomain_resourceloader_filerenderer;
    //     return $pop_multidomain_resourceloader_filerenderer;
    // }
    protected function getFragmentObjects(): array
    {
        return [
            new PoP_MultiDomain_ResourceLoader_FileReproduction_Config(),
        ];
    }
}
    
/**
 * Initialize
 */
global $pop_multidomain_resourceloader_configfile;
$pop_multidomain_resourceloader_configfile = new PoP_MultiDomain_ResourceLoader_ConfigFile();
