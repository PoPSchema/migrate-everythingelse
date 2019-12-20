<?php
use PoP\Posts\Facades\PostTypeAPIFacade;

class PoP_AddHighlights_Module_Processor_SingleSectionTabPanelBlocks extends PoP_Module_Processor_SingleTabPanelSectionBlocksBase
{
    public const MODULE_BLOCK_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT = 'block-tabpanel-singlerelatedhighlightcontent';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_BLOCK_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT],
        );
    }

    protected function getInnerSubmodules(array $module): array
    {
        $ret = parent::getInnerSubmodules($module);

        $inners = array(
            self::MODULE_BLOCK_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT => [PoP_AddHighlights_Module_Processor_SingleSectionTabPanelComponents::class, PoP_AddHighlights_Module_Processor_SingleSectionTabPanelComponents::MODULE_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT],
        );
        if ($inner = $inners[$module[1]]) {
            $ret[] = $inner;
        }

        return $ret;
    }

    protected function getControlgroupBottomSubmodule(array $module)
    {
        switch ($module[1]) {
            case self::MODULE_BLOCK_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT:
                return [PoP_Module_Processor_CustomControlGroups::class, PoP_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_SUBMENUPOSTLIST];
        }

        return parent::getControlgroupBottomSubmodule($module);
    }

    public function initRequestProps(array $module, array &$props)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        switch ($module[1]) {
            case self::MODULE_BLOCK_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT:
                $post_id = $vars['routing-state']['queried-object-id'];
                if ($postTypeAPI->getStatus($post_id) !== POP_POSTSTATUS_PUBLISHED) {
                    $this->setProp($module, $props, 'show-controls-bottom', false);
                }
                break;
        }

        parent::initRequestProps($module, $props);
    }

    public function getDelegatorfilterSubmodule(array $module)
    {
        switch ($module[1]) {
            case self::MODULE_BLOCK_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT:
                return [PoP_AddHighlights_Module_Processor_CustomFilters::class, PoP_AddHighlights_Module_Processor_CustomFilters::MODULE_FILTER_HIGHLIGHTS];
        }

        return parent::getDelegatorfilterSubmodule($module);
    }
}


