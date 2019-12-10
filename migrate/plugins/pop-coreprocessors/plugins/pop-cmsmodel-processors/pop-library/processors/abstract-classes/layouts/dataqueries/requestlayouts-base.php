<?php

abstract class PoP_Module_Processor_RequestLayoutsBase extends PoP_Module_Processor_LayoutsDataQueriesBase
{
    protected function getLayoutSubmodules(array $module)
    {
        $layouts = parent::getLayoutSubmodules($module);

        // Remove the Lazy Loading spinner
        $layouts[] = [PoP_Module_Processor_LazyLoadingRemoveLayouts::class, PoP_Module_Processor_LazyLoadingRemoveLayouts::MODULE_SCRIPT_LAZYLOADINGREMOVE];

        return $layouts;
    }

    public function initModelProps(array $module, array &$props)
    {
        $layouts = $this->getLayoutSubmodules($module);
        foreach ($layouts as $layout) {
            $this->appendProp($layout, $props, 'class', 'pop-lazyloaded-layout');
        }

        parent::initModelProps($module, $props);
    }
}
