<?php

class PoP_Taxonomies_Module_Processor_TaxonomiesContents extends PoP_Module_Processor_ContentsBase
{
    public const MODULE_CONTENT_DATAQUERY_TAGS_UPDATEDATA = 'content-dataquery-tags-updatedata';
    public const MODULE_CONTENT_DATAQUERY_TAGS_REQUESTLAYOUTS = 'content-dataquery-tags-requestlayouts';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_CONTENT_DATAQUERY_TAGS_UPDATEDATA],
            [self::class, self::MODULE_CONTENT_DATAQUERY_TAGS_REQUESTLAYOUTS],
        );
    }
    public function getInnerSubmodule(array $module)
    {
        $inners = array(
            self::MODULE_CONTENT_DATAQUERY_TAGS_UPDATEDATA => [PoP_Taxonomies_Module_Processor_TaxonomiesMultipleContentInners::class, PoP_Taxonomies_Module_Processor_TaxonomiesMultipleContentInners::MODULE_CONTENTINNER_DATAQUERY_TAGS_UPDATEDATA],
            self::MODULE_CONTENT_DATAQUERY_TAGS_REQUESTLAYOUTS => [PoP_Taxonomies_Module_Processor_TaxonomiesMultipleContentInners::class, PoP_Taxonomies_Module_Processor_TaxonomiesMultipleContentInners::MODULE_CONTENTINNER_DATAQUERY_TAGS_REQUESTLAYOUTS],
        );

        if ($inner = $inners[$module[1]]) {
            return $inner;
        }

        return parent::getInnerSubmodule($module);
    }
}


