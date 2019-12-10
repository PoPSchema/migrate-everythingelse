<?php

class PoP_Users_Module_Processor_UsersMultipleContentInners extends PoP_Module_Processor_ContentMultipleInnersBase
{
    public const MODULE_CONTENTINNER_DATAQUERY_USERS_UPDATEDATA = 'contentinner-dataquery-users-updatedata';
    public const MODULE_CONTENTINNER_DATAQUERY_USERS_REQUESTLAYOUTS = 'contentinner-dataquery-users-requestlayouts';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_CONTENTINNER_DATAQUERY_USERS_UPDATEDATA],
            [self::class, self::MODULE_CONTENTINNER_DATAQUERY_USERS_REQUESTLAYOUTS],
        );
    }

    public function getLayoutSubmodules(array $module)
    {
        $ret = parent::getLayoutSubmodules($module);

        switch ($module[1]) {
            case self::MODULE_CONTENTINNER_DATAQUERY_USERS_UPDATEDATA:
                // The module, inheriting from base class PoP_Module_Processor_FieldsDataQueriesBase, must be hooked in
                $layout = PoP_CMSModel_Utils::getFieldsModule();
                if ($layout) {
                    $ret[] = $layout;
                }
                break;

            case self::MODULE_CONTENTINNER_DATAQUERY_USERS_REQUESTLAYOUTS:
                // The module, inheriting from base class PoP_Module_Processor_LayoutsDataQueriesBase, must be hooked in
                $layout = PoP_CMSModel_Utils::getLayoutsModule();
                if ($layout) {
                    $ret[] = $layout;
                }
                break;
        }

        return $ret;
    }
}


