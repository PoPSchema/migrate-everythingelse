<?php
use PoP\Engine\ModuleProcessors\DBObjectIDsFromURLParamModuleProcessorTrait;
use PoP\Taxonomies\TypeResolvers\TagTypeResolver;

class PoP_Taxonomies_Module_Processor_TaxonomiesDataloads extends PoP_Module_Processor_DataloadsBase
{
    use DBObjectIDsFromURLParamModuleProcessorTrait;

    public const MODULE_DATALOAD_DATAQUERY_TAGS_UPDATEDATA = 'dataload-dataquery-tags-updatedata';
    public const MODULE_DATALOAD_DATAQUERY_TAGS_REQUESTLAYOUTS = 'dataload-dataquery-tags-requestlayouts';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_DATAQUERY_TAGS_UPDATEDATA],
            [self::class, self::MODULE_DATALOAD_DATAQUERY_TAGS_REQUESTLAYOUTS],
        );
    }

    public function getRelevantRoute(array $module, array &$props): ?string
    {
        $routes = array(
            self::MODULE_DATALOAD_DATAQUERY_TAGS_REQUESTLAYOUTS => POP_TAXONOMIES_ROUTE_LOADERS_TAGS_LAYOUTS,
            self::MODULE_DATALOAD_DATAQUERY_TAGS_UPDATEDATA => POP_TAXONOMIES_ROUTE_LOADERS_TAGS_FIELDS,
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
            self::MODULE_DATALOAD_DATAQUERY_TAGS_UPDATEDATA => [PoP_Taxonomies_Module_Processor_TaxonomiesContents::class, PoP_Taxonomies_Module_Processor_TaxonomiesContents::MODULE_CONTENT_DATAQUERY_TAGS_UPDATEDATA],
            self::MODULE_DATALOAD_DATAQUERY_TAGS_REQUESTLAYOUTS => [PoP_Taxonomies_Module_Processor_TaxonomiesContents::class, PoP_Taxonomies_Module_Processor_TaxonomiesContents::MODULE_CONTENT_DATAQUERY_TAGS_REQUESTLAYOUTS],
        );

        return $inner_modules[$module[1]];
    }

    public function getFormat(array $module): ?string
    {
        $updatedatas = array(
            [self::class, self::MODULE_DATALOAD_DATAQUERY_TAGS_UPDATEDATA],
        );
        $requestlayouts = array(
            [self::class, self::MODULE_DATALOAD_DATAQUERY_TAGS_REQUESTLAYOUTS],
        );

        if (in_array($module, $updatedatas)) {
            $format = POP_FORMAT_FIELDS;
        } elseif (in_array($module, $requestlayouts)) {
            $format = POP_FORMAT_LAYOUTS;
        }

        return $format ?? parent::getFormat($module);
    }

    public function getDBObjectIDOrIDs(array $module, array &$props, &$data_properties)
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_DATAQUERY_TAGS_UPDATEDATA:
            case self::MODULE_DATALOAD_DATAQUERY_TAGS_REQUESTLAYOUTS:
                return $this->getDBObjectIDsFromURLParam($module, $props, $data_properties);
        }
        return parent::getDBObjectIDOrIDs($module, $props, $data_properties);
    }

    protected function getDBObjectIDsParamName(array $module, array &$props, &$data_properties)
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_DATAQUERY_TAGS_UPDATEDATA:
            case self::MODULE_DATALOAD_DATAQUERY_TAGS_REQUESTLAYOUTS:
                return POP_INPUTNAME_TAGID;
        }
        return null;
    }

    public function getTypeResolverClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_DATAQUERY_TAGS_UPDATEDATA:
            case self::MODULE_DATALOAD_DATAQUERY_TAGS_REQUESTLAYOUTS:
                return TagTypeResolver::class;
        }

        return parent::getTypeResolverClass($module);
    }

    public function initModelProps(array $module, array &$props)
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_DATAQUERY_TAGS_UPDATEDATA:
            case self::MODULE_DATALOAD_DATAQUERY_TAGS_REQUESTLAYOUTS:
                // These blocks must be hidden, so that the feedbackmessage from blocks in the operational are pulled all the way up.
                // If these are hidden, these feedbackmessages are pulled down and out of screen
                $this->appendProp($module, $props, 'class', 'hidden');
                break;
        }
        
        parent::initModelProps($module, $props);
    }
}



