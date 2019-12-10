<?php

class PoP_Taxonomies_Module_Processor_TaxonomiesMultipleContentInners extends PoP_Module_Processor_ContentMultipleInnersBase
{
    public const MODULE_CONTENTINNER_DATAQUERY_TAGS_UPDATEDATA = 'contentinner-dataquery-tags-updatedata';
    public const MODULE_CONTENTINNER_DATAQUERY_TAGS_REQUESTLAYOUTS = 'contentinner-dataquery-tags-requestlayouts';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_CONTENTINNER_DATAQUERY_TAGS_UPDATEDATA],
            [self::class, self::MODULE_CONTENTINNER_DATAQUERY_TAGS_REQUESTLAYOUTS],
        );
    }

    public function getLayoutSubmodules(array $module)
    {
        $ret = parent::getLayoutSubmodules($module);

        switch ($module[1]) {
            case self::MODULE_CONTENTINNER_DATAQUERY_TAGS_UPDATEDATA:
                // The module, inheriting from base class PoP_Module_Processor_FieldsDataQueriesBase, must be hooked in
                $layout = PoP_CMSModel_Utils::getFieldsModule();
                if ($layout) {
                    $ret[] = $layout;
                }
                break;

            case self::MODULE_CONTENTINNER_DATAQUERY_TAGS_REQUESTLAYOUTS:
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


