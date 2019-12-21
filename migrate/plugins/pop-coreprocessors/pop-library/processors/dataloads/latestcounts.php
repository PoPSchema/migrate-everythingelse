<?php
use PoP\ComponentModel\TypeResolvers\UnionTypeHelpers;
use PoP\Content\TypeResolvers\ContentEntityUnionTypeResolver;
use PoP\Application\QueryInputOutputHandlers\ListQueryInputOutputHandler;

class GD_Core_Module_Processor_Dataloads extends PoP_Module_Processor_DataloadsBase
{
    public const MODULE_DATALOAD_LATESTCOUNTS = 'dataload-latestcounts';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_LATESTCOUNTS],
        );
    }

    protected function getInnerSubmodules(array $module): array
    {
        $ret = parent::getInnerSubmodules($module);

        $inner_modules = array(
            self::MODULE_DATALOAD_LATESTCOUNTS => [PoPCore_Module_Processor_Contents::class, PoPCore_Module_Processor_Contents::MODULE_CONTENT_LATESTCOUNTS],
        );

        if ($inner = $inner_modules[$module[1]]) {
            $ret[] = $inner;
        }

        return $ret;
    }

    protected function getImmutableDataloadQueryArgs(array $module, array &$props): array
    {
        $ret = parent::getImmutableDataloadQueryArgs($module, $props);

        switch ($module[1]) {
            case self::MODULE_DATALOAD_LATESTCOUNTS:
                PoP_Application_SectionUtils::addDataloadqueryargsLatestcounts($ret);
                break;
        }

        return $ret;
    }

    public function getFormat(array $module): ?string
    {

        // Set the display configuration
        $latestcounts = array(
            [self::class, self::MODULE_DATALOAD_LATESTCOUNTS],
        );

        if (in_array($module, $latestcounts)) {
            $format = POP_FORMAT_LATESTCOUNT;
        }

        return $format ?? parent::getFormat($module);
    }

    public function getQueryInputOutputHandlerClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_LATESTCOUNTS:
                return ListQueryInputOutputHandler::class;
        }

        return parent::getQueryInputOutputHandlerClass($module);
    }

    public function getTypeResolverClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_LATESTCOUNTS:
                return UnionTypeHelpers::getUnionOrTargetTypeResolverClass(ContentEntityUnionTypeResolver::class);
        }

        return parent::getTypeResolverClass($module);
    }

    public function initModelProps(array $module, array &$props)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        switch ($module[1]) {
            case self::MODULE_DATALOAD_LATESTCOUNTS:
                // It can be invisible, nothing to show
                $this->appendProp($module, $props, 'class', 'hidden');

                // Do not load initially. Load only needed when executing the setTimeout with loadLatest
                if ($vars['fetching-site']) {
                    $this->setProp($module, $props, 'skip-data-load', true);
                }
                break;
        }

        parent::initModelProps($module, $props);
    }
}



