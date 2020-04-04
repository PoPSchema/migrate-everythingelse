<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\GeneralUtils;
use PoP\ComponentModel\State\ApplicationState;

class PoP_SPAResourceLoader_FileReproduction_Config extends \PoP\FileStore\File\AbstractRenderableFileFragment
{
    // public function getRenderer()
    // {
    //     global $pop_sparesourceloader_configfile_renderer;
    //     return $pop_sparesourceloader_configfile_renderer;
    // }

    public function getAssetsPath()
    {
        return POP_SPARESOURCELOADER_ASSETS_DIR.'/js/jobs/resourceloader-config.js';
    }
    
    public function getConfiguration()
    {
        $configuration = parent::getConfiguration();
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
        $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();
        $vars = ApplicationState::getVars();

        // Domain
        $configuration['$domain'] = $cmsengineapi->getSiteURL();
        // $configuration['$pathStartPos'] = strlen(GeneralUtils::maybeAddTrailingSlash($cmsengineapi->getHomeURL()));

        // Get the list of all categories, and then their paths
        $categories = $taxonomyapi->getCategories(['hide-empty' => false], ['return-type' => POP_RETURNTYPE_IDS]);
        $single_paths = array_map(array($taxonomyapi, 'getCategoryPath'), $categories);

        // Allow EM to add their own paths
        $single_paths = HooksAPIFacade::getInstance()->applyFilters(
            'PoP_SPAResourceLoader_FileReproduction_Config:configuration:category-paths',
            $single_paths
        );

        // Path slugs
        $configuration['$paths'] = array(
            'author' => $cmsusersapi->getAuthorBase().'/',
            'tag' => $taxonomyapi->getTagBase().'/',
            'single' => $single_paths,
        );

        global $pop_sparesourceloader_natureformatcombinationresources_configfile;
        $configFileURLPlaceholder =
            $pop_sparesourceloader_natureformatcombinationresources_configfile->getUrl()
            .'/'
            .$pop_sparesourceloader_natureformatcombinationresources_configfile->getVariableFilename('{0}', '{1}');
        $configFileURLPlaceholder = GeneralUtils::addQueryArgs([
            'ver' => $vars['version'], 
        ], $configFileURLPlaceholder);
        $configuration['$configFileURLPlaceholder'] = $configFileURLPlaceholder;
        
        $configuration['$configTypes'] = array(
            POP_RESOURCELOADER_RESOURCETYPE_JS => array(),
            POP_RESOURCELOADER_RESOURCETYPE_CSS => array(),
        );

        return $configuration;
    }
}
   