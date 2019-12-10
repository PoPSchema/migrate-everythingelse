<?php

class PoP_Pages_Module_Processor_PagesContents extends PoP_Module_Processor_ContentsBase
{
    public const MODULE_CONTENT_DATAQUERY_PAGECONTENT_UPDATEDATA = 'content-dataquery-pagecontent-updatedata';
    public const MODULE_CONTENT_DATAQUERY_PAGECONTENT_REQUESTLAYOUTS = 'content-dataquery-pagecontent-requestlayouts';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_CONTENT_DATAQUERY_PAGECONTENT_UPDATEDATA],
            [self::class, self::MODULE_CONTENT_DATAQUERY_PAGECONTENT_REQUESTLAYOUTS],
        );
    }
    public function getInnerSubmodule(array $module)
    {
        $inners = array(
            self::MODULE_CONTENT_DATAQUERY_PAGECONTENT_UPDATEDATA => [PoP_Pages_Module_Processor_PagesMultipleContentInners::class, PoP_Pages_Module_Processor_PagesMultipleContentInners::MODULE_CONTENTINNER_DATAQUERY_PAGECONTENT_UPDATEDATA],
            self::MODULE_CONTENT_DATAQUERY_PAGECONTENT_REQUESTLAYOUTS => [PoP_Pages_Module_Processor_PagesMultipleContentInners::class, PoP_Pages_Module_Processor_PagesMultipleContentInners::MODULE_CONTENTINNER_DATAQUERY_PAGECONTENT_REQUESTLAYOUTS],
        );

        if ($inner = $inners[$module[1]]) {
            return $inner;
        }

        return parent::getInnerSubmodule($module);
    }
}


