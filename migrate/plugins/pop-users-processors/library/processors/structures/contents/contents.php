<?php

class PoP_Users_Module_Processor_UsersContents extends PoP_Module_Processor_ContentsBase
{
    public const MODULE_CONTENT_DATAQUERY_USERS_UPDATEDATA = 'content-dataquery-users-updatedata';
    public const MODULE_CONTENT_DATAQUERY_USERS_REQUESTLAYOUTS = 'content-dataquery-users-requestlayouts';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_CONTENT_DATAQUERY_USERS_UPDATEDATA],
            [self::class, self::MODULE_CONTENT_DATAQUERY_USERS_REQUESTLAYOUTS],
        );
    }
    public function getInnerSubmodule(array $module)
    {
        $inners = array(
            self::MODULE_CONTENT_DATAQUERY_USERS_UPDATEDATA => [PoP_Users_Module_Processor_UsersMultipleContentInners::class, PoP_Users_Module_Processor_UsersMultipleContentInners::MODULE_CONTENTINNER_DATAQUERY_USERS_UPDATEDATA],
            self::MODULE_CONTENT_DATAQUERY_USERS_REQUESTLAYOUTS => [PoP_Users_Module_Processor_UsersMultipleContentInners::class, PoP_Users_Module_Processor_UsersMultipleContentInners::MODULE_CONTENTINNER_DATAQUERY_USERS_REQUESTLAYOUTS],
        );

        if ($inner = $inners[$module[1]]) {
            return $inner;
        }

        return parent::getInnerSubmodule($module);
    }
}


