<?php

class PoP_Posts_Module_Processor_PostsMultipleContentInners extends PoP_Module_Processor_ContentMultipleInnersBase
{
    public const MODULE_CONTENTINNER_DATAQUERY_CONTENT_UPDATEDATA = 'contentinner-dataquery-content-updatedata';
    public const MODULE_CONTENTINNER_DATAQUERY_CONTENT_REQUESTLAYOUTS = 'contentinner-dataquery-content-requestlayouts';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_CONTENTINNER_DATAQUERY_CONTENT_UPDATEDATA],
            [self::class, self::MODULE_CONTENTINNER_DATAQUERY_CONTENT_REQUESTLAYOUTS],
        );
    }

    public function getLayoutSubmodules(array $module)
    {
        $ret = parent::getLayoutSubmodules($module);

        switch ($module[1]) {
            case self::MODULE_CONTENTINNER_DATAQUERY_CONTENT_UPDATEDATA:
                // The module, inheriting from base class PoP_Module_Processor_FieldsDataQueriesBase, must be hooked in
                $layout = PoP_CMSModel_Utils::getFieldsModule();
                if ($layout) {
                    $ret[] = $layout;
                }
                break;

            case self::MODULE_CONTENTINNER_DATAQUERY_CONTENT_REQUESTLAYOUTS:
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


