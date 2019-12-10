<?php

class PoP_Pages_Module_Processor_PagesDataloads extends PoP_Module_Processor_DataloadsBase
{
    public const MODULE_DATALOAD_DATAQUERY_PAGECONTENT_UPDATEDATA = 'dataload-dataquery-pagecontent-updatedata';
    public const MODULE_DATALOAD_DATAQUERY_PAGECONTENT_REQUESTLAYOUTS = 'dataload-dataquery-pagecontent-requestlayouts';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_UPDATEDATA],
            [self::class, self::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_REQUESTLAYOUTS],
        );
    }

    public function getRelevantRoute(array $module, array &$props): ?string
    {
        $routes = array(
            self::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_REQUESTLAYOUTS => POP_PAGES_ROUTE_LOADERS_PAGES_LAYOUTS,
            self::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_UPDATEDATA => POP_PAGES_ROUTE_LOADERS_PAGES_FIELDS,
        );
        return $routes[$module[1]] ?? parent::getRelevantRoute($module, $props);
    }

    protected function getInnerSubmodules(array $module): array
    {
        if ($inner_module = $this->getInnerSubmodule($module)) {
            $ret[] = $inner_module;
        }

        return $ret;
    }

    public function getInnerSubmodule(array $module)
    {
        $inner_modules = array(
            self::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_UPDATEDATA => [PoP_Pages_Module_Processor_PagesContents::class, PoP_Pages_Module_Processor_PagesContents::MODULE_CONTENT_DATAQUERY_PAGECONTENT_UPDATEDATA],
            self::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_REQUESTLAYOUTS => [PoP_Pages_Module_Processor_PagesContents::class, PoP_Pages_Module_Processor_PagesContents::MODULE_CONTENT_DATAQUERY_PAGECONTENT_REQUESTLAYOUTS],
        );

        return $inner_modules[$module[1]];
    }

    public function getFormat(array $module): ?string
    {
        $updatedatas = array(
            [self::class, self::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_UPDATEDATA],
        );
        $requestlayouts = array(
            [self::class, self::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_REQUESTLAYOUTS],
        );

        if (in_array($module, $updatedatas)) {
            $format = POP_FORMAT_FIELDS;
        } elseif (in_array($module, $requestlayouts)) {
            $format = POP_FORMAT_LAYOUTS;
        }

        return $format ?? parent::getFormat($module);
    }

    public function getTypeDataResolverClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_UPDATEDATA:
            case self::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_REQUESTLAYOUTS:
                return GD_TYPEDATARESOLVER_PARAMPAGE;
        }

        return parent::getTypeDataResolverClass($module);
    }

    public function initModelProps(array $module, array &$props)
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_UPDATEDATA:
            case self::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_REQUESTLAYOUTS:
                // These blocks must be hidden, so that the feedbackmessage from blocks in the operational are pulled all the way up.
                // If these are hidden, these feedbackmessages are pulled down and out of screen
                $this->appendProp($module, $props, 'class', 'hidden');
                break;
        }
        
        parent::initModelProps($module, $props);
    }
}



