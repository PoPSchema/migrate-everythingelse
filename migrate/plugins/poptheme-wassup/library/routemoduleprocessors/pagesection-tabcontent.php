<?php

use PoP\Routing\RouteNatures;
use PoP\Pages\Routing\RouteNatures as PageRouteNatures;
use PoP\CustomPosts\Routing\RouteNatures as CustomPostRouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;
use PoP\Tags\Routing\RouteNatures as TaxonomyRouteNatures;

class PoP_Module_TabContentPageSectionRouteModuleProcessor extends PoP_Module_TabContentPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNature()
    {
        $ret = array();

        $nature_modules = array(
            RouteNatures::HOME => [PoP_Module_Processor_PageTabsLayouts::class, PoP_Module_Processor_PageTabsLayouts::MODULE_LAYOUT_PAGETABS_HOME],
            UserRouteNatures::USER => [PoP_Module_Processor_PageTabsLayouts::class, PoP_Module_Processor_PageTabsLayouts::MODULE_LAYOUT_PAGETABS_AUTHOR],
            CustomPostRouteNatures::CUSTOMPOST => [PoP_Module_Processor_PageTabsLayouts::class, PoP_Module_Processor_PageTabsLayouts::MODULE_LAYOUT_PAGETABS_SINGLE],
            TaxonomyRouteNatures::TAG => [PoP_Module_Processor_PageTabsLayouts::class, PoP_Module_Processor_PageTabsLayouts::MODULE_LAYOUT_PAGETABS_TAG],
            RouteNatures::NOTFOUND => [PoP_Module_Processor_PageTabsLayouts::class, PoP_Module_Processor_PageTabsLayouts::MODULE_LAYOUT_PAGETABS_404],
            PageRouteNatures::PAGE => [PoP_Module_Processor_PageTabsLayouts::class, PoP_Module_Processor_PageTabsLayouts::MODULE_LAYOUT_PAGETABS_PAGE],
            RouteNatures::STANDARD => [PoP_Module_Processor_PageTabsLayouts::class, PoP_Module_Processor_PageTabsLayouts::MODULE_LAYOUT_PAGETABS_ROUTE],
        );
        foreach ($nature_modules as $nature => $module) {
            $ret[$nature][] = [
                'module' => $module,
            ];
        }

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ModuleRouting\Facades\RouteModuleProcessorManagerFacade::getInstance()->add(
		new PoP_Module_TabContentPageSectionRouteModuleProcessor()
	);
}, 200);
