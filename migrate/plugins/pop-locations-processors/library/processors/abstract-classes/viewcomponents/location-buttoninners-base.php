<?php
use PoP\ComponentModel\Modules\ModuleUtils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoP\Locations\TypeDataResolvers\LocationTypeDataResolver;

abstract class PoP_Module_Processor_LocationViewComponentButtonInnersBase extends PoP_Module_Processor_ButtonInnersBase
{
    public function getTemplateResource(array $module, array &$props): ?array
    {
        return [PoP_Locations_TemplateResourceLoaderProcessor::class, PoP_Locations_TemplateResourceLoaderProcessor::RESOURCE_VIEWCOMPONENT_LOCATIONBUTTONINNER];
    }

    // function getLocationModule(array $module, array &$props) {
    public function getLocationModule(array $module)
    {
        return null;
    }
    public function separator(array $module, array &$props)
    {
        return ' | ';
    }

    public function getFontawesome(array $module, array &$props)
    {
        return 'fa-map-marker';
    }

    public function getImmutableConfiguration(array $module, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($module, $props);

        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        // if ($location_module = $this->getLocationModule($module, $props)) {
        if ($location_module = $this->getLocationModule($module)) {
            // $ret['separator'] = $this->getProp($module, $props, 'separator');
            $ret['separator'] = $this->separator($module, $props);
            $ret[GD_JS_SUBMODULEOUTPUTNAMES]['location-layout'] = ModuleUtils::getModuleOutputName($location_module);
        } else {
            $ret[GD_JS_TITLES] = array(
                'locations' => TranslationAPIFacade::getInstance()->__('Locations', 'em-popprocessors')
            );
        }
        
        return $ret;
    }

    // function getDomainSwitchingSubmodules(array $module, array &$props) {
    public function getDomainSwitchingSubmodules(array $module): array
    {
    
        // if ($location_module = $this->getLocationModule($module, $props)) {
        if ($location_module = $this->getLocationModule($module)) {
            return array(
                'locations' => array(
                    LocationTypeDataResolver::class => array(
                        $location_module,
                    ),
                ),
            );
        }

        return parent::getDomainSwitchingSubmodules($module);
    }
}
