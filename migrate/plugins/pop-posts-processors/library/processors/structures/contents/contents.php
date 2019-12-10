<?php

class PoP_Posts_Module_Processor_PostsContents extends PoP_Module_Processor_ContentsBase
{
    public const MODULE_CONTENT_DATAQUERY_CONTENT_UPDATEDATA = 'content-dataquery-content-updatedata';
    public const MODULE_CONTENT_DATAQUERY_CONTENT_REQUESTLAYOUTS = 'content-dataquery-content-requestlayouts';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_CONTENT_DATAQUERY_CONTENT_UPDATEDATA],
            [self::class, self::MODULE_CONTENT_DATAQUERY_CONTENT_REQUESTLAYOUTS],
        );
    }
    public function getInnerSubmodule(array $module)
    {
        $inners = array(
            self::MODULE_CONTENT_DATAQUERY_CONTENT_UPDATEDATA => [PoP_Posts_Module_Processor_PostsMultipleContentInners::class, PoP_Posts_Module_Processor_PostsMultipleContentInners::MODULE_CONTENTINNER_DATAQUERY_CONTENT_UPDATEDATA],
            self::MODULE_CONTENT_DATAQUERY_CONTENT_REQUESTLAYOUTS => [PoP_Posts_Module_Processor_PostsMultipleContentInners::class, PoP_Posts_Module_Processor_PostsMultipleContentInners::MODULE_CONTENTINNER_DATAQUERY_CONTENT_REQUESTLAYOUTS],
        );

        if ($inner = $inners[$module[1]]) {
            return $inner;
        }

        return parent::getInnerSubmodule($module);
    }
}


