<?php

class Wassup_Module_Processor_CategoriesLayouts extends PoP_Module_Processor_CategoriesLayoutsBase
{
    public const MODULE_LAYOUT_CATEGORIES = 'layout-categories';
    public const MODULE_LAYOUT_APPLIESTO = 'layout-appliesto';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_LAYOUT_CATEGORIES],
            [self::class, self::MODULE_LAYOUT_APPLIESTO],
        );
    }

    public function getCategoriesField(array $module, array &$props)
    {
        switch ($module[1]) {
            case self::MODULE_LAYOUT_CATEGORIES:
                return 'topics-byname';

            case self::MODULE_LAYOUT_APPLIESTO:
                return 'appliesto-byname';
        }
        
        return parent::getCategoriesField($module, $props);
    }
    public function getLabelClass(array $module, array &$props)
    {
        switch ($module[1]) {
            case self::MODULE_LAYOUT_APPLIESTO:
                return 'label-primary';
        }
        
        return parent::getLabelClass($module, $props);
    }
}



