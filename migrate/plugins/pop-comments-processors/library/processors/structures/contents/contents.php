<?php

class PoP_Comments_Module_Processor_CommentsContents extends PoP_Module_Processor_ContentsBase
{
    public const MODULE_CONTENT_DATAQUERY_COMMENTS_UPDATEDATA = 'content-dataquery-comments-updatedata';
    public const MODULE_CONTENT_DATAQUERY_COMMENTS_REQUESTLAYOUTS = 'content-dataquery-comments-requestlayouts';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_CONTENT_DATAQUERY_COMMENTS_UPDATEDATA],
            [self::class, self::MODULE_CONTENT_DATAQUERY_COMMENTS_REQUESTLAYOUTS],
        );
    }
    public function getInnerSubmodule(array $module)
    {
        $inners = array(
            self::MODULE_CONTENT_DATAQUERY_COMMENTS_UPDATEDATA => [PoP_Comments_Module_Processor_CommentsMultipleContentInners::class, PoP_Comments_Module_Processor_CommentsMultipleContentInners::MODULE_CONTENTINNER_DATAQUERY_COMMENTS_UPDATEDATA],
            self::MODULE_CONTENT_DATAQUERY_COMMENTS_REQUESTLAYOUTS => [PoP_Comments_Module_Processor_CommentsMultipleContentInners::class, PoP_Comments_Module_Processor_CommentsMultipleContentInners::MODULE_CONTENTINNER_DATAQUERY_COMMENTS_REQUESTLAYOUTS],
        );

        if ($inner = $inners[$module[1]]) {
            return $inner;
        }

        return parent::getInnerSubmodule($module);
    }
}


