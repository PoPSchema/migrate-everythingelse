<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Taxonomies\TypeResolvers\TagTypeResolver;
use PoP\ComponentModel\TypeResolvers\UnionTypeHelpers;
use PoP\CustomPosts\TypeResolvers\CustomPostUnionTypeResolver;
use PoP\QueriedObject\ModuleProcessors\QueriedDBObjectModuleProcessorTrait;

class PoP_Module_Processor_CustomSidebarDataloads extends PoP_Module_Processor_DataloadsBase
{
    use QueriedDBObjectModuleProcessorTrait;

    public const MODULE_DATALOAD_TAG_SIDEBAR = 'dataload-tag-sidebar';
    public const MODULE_DATALOAD_SINGLE_POST_SIDEBAR = 'dataload-single-post-sidebar';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_TAG_SIDEBAR],
            [self::class, self::MODULE_DATALOAD_SINGLE_POST_SIDEBAR],
        );
    }

    protected function getInnerSubmodules(array $module): array
    {
        $ret = parent::getInnerSubmodules($module);

        $orientation = HooksAPIFacade::getInstance()->applyFilters(POP_HOOK_BLOCKSIDEBARS_ORIENTATION, 'vertical');
        $vertical = ($orientation == 'vertical');

        $block_inners = array(
            self::MODULE_DATALOAD_TAG_SIDEBAR => $vertical ?
                [Wassup_Module_Processor_CustomVerticalTagSidebars::class, Wassup_Module_Processor_CustomVerticalTagSidebars::MODULE_VERTICALSIDEBAR_TAG] :
                [PoP_Module_Processor_CustomTagLayoutSidebars::class, PoP_Module_Processor_CustomTagLayoutSidebars::MODULE_LAYOUT_TAGSIDEBAR_HORIZONTAL],
            self::MODULE_DATALOAD_SINGLE_POST_SIDEBAR => $vertical ?
                [Wassup_Module_Processor_CustomVerticalSingleSidebars::class, Wassup_Module_Processor_CustomVerticalSingleSidebars::MODULE_VERTICALSIDEBAR_SINGLE_POST] :
                [PoP_Module_Processor_CustomPostLayoutSidebars::class, PoP_Module_Processor_CustomPostLayoutSidebars::MODULE_LAYOUT_POSTSIDEBAR_HORIZONTAL_POST],
        );

        if ($block_inner = $block_inners[$module[1]]) {
            $ret[] = $block_inner;
        }

        return $ret;
    }

    // public function getNature(array $module)
    // {
    //     switch ($module[1]) {
    //         case self::MODULE_DATALOAD_TAG_SIDEBAR:
    //             return TaxonomyRouteNatures::TAG;

    //         case self::MODULE_DATALOAD_SINGLE_POST_SIDEBAR:
    //             return PostRouteNatures::POST;
    //     }

    //     return parent::getNature($module);
    // }

    public function getDBObjectIDOrIDs(array $module, array &$props, &$data_properties)
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_SINGLE_POST_SIDEBAR:
            case self::MODULE_DATALOAD_TAG_SIDEBAR:
                return $this->getQueriedDBObjectID($module, $props, $data_properties);
        }

        return parent::getDBObjectIDOrIDs($module, $props, $data_properties);
    }

    public function getTypeResolverClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_TAG_SIDEBAR:
                return TagTypeResolver::class;

            case self::MODULE_DATALOAD_SINGLE_POST_SIDEBAR:
                return UnionTypeHelpers::getUnionOrTargetTypeResolverClass(CustomPostUnionTypeResolver::class);
        }

        return parent::getTypeResolverClass($module);
    }
}



