<?php
use PoP\API\ModuleProcessors\AbstractRelationalFieldDataloadModuleProcessor;
use PoP\Application\QueryInputOutputHandlers\ListQueryInputOutputHandler;
use PoP\Posts\TypeResolvers\PostTypeResolver;
use PoP\Posts\TypeResolvers\PostConvertibleTypeResolver;
use PoP\Taxonomies\TypeResolvers\TagTypeResolver;
use PoP\Users\TypeResolvers\UserTypeResolver;

class PoP_Blog_Module_Processor_FieldDataloads extends AbstractRelationalFieldDataloadModuleProcessor
{
    public const MODULE_DATALOAD_DATAQUERY_CONTENTLIST_FIELDS = 'blog-dataload-dataquery-contentlist-fields';
    public const MODULE_DATALOAD_DATAQUERY_POSTLIST_FIELDS = 'blog-dataload-dataquery-postlist-fields';
    public const MODULE_DATALOAD_DATAQUERY_USERLIST_FIELDS = 'blog-dataload-dataquery-userlist-fields';
    public const MODULE_DATALOAD_DATAQUERY_TAGLIST_FIELDS = 'blog-dataload-dataquery-taglist-fields';
    public const MODULE_DATALOAD_DATAQUERY_AUTHORPOSTLIST_FIELDS = 'blog-dataload-dataquery-authorpostlist-fields';
    public const MODULE_DATALOAD_DATAQUERY_AUTHORCONTENTLIST_FIELDS = 'blog-dataload-dataquery-authorcontentlist-fields';
    public const MODULE_DATALOAD_DATAQUERY_TAGPOSTLIST_FIELDS = 'blog-dataload-dataquery-tagpostlist-fields';
    public const MODULE_DATALOAD_DATAQUERY_TAGCONTENTLIST_FIELDS = 'blog-dataload-dataquery-tagcontentlist-fields';
    public const MODULE_DATALOAD_DATAQUERY_SINGLEAUTHORLIST_FIELDS = 'blog-dataload-dataquery-singleauthorlist-fields';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_DATAQUERY_CONTENTLIST_FIELDS],
            [self::class, self::MODULE_DATALOAD_DATAQUERY_POSTLIST_FIELDS],
            [self::class, self::MODULE_DATALOAD_DATAQUERY_USERLIST_FIELDS],
            [self::class, self::MODULE_DATALOAD_DATAQUERY_TAGLIST_FIELDS],
            [self::class, self::MODULE_DATALOAD_DATAQUERY_AUTHORPOSTLIST_FIELDS],
            [self::class, self::MODULE_DATALOAD_DATAQUERY_AUTHORCONTENTLIST_FIELDS],
            [self::class, self::MODULE_DATALOAD_DATAQUERY_TAGPOSTLIST_FIELDS],
            [self::class, self::MODULE_DATALOAD_DATAQUERY_TAGCONTENTLIST_FIELDS],
            [self::class, self::MODULE_DATALOAD_DATAQUERY_SINGLEAUTHORLIST_FIELDS],
        );
    }

    public function getTypeResolverClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_DATAQUERY_POSTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_AUTHORPOSTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_TAGPOSTLIST_FIELDS:
                return PostTypeResolver::class;

            case self::MODULE_DATALOAD_DATAQUERY_CONTENTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_AUTHORCONTENTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_TAGCONTENTLIST_FIELDS:
                return PostConvertibleTypeResolver::class;

            case self::MODULE_DATALOAD_DATAQUERY_USERLIST_FIELDS:
                return UserTypeResolver::class;

            case self::MODULE_DATALOAD_DATAQUERY_TAGLIST_FIELDS:
                return TagTypeResolver::class;

            case self::MODULE_DATALOAD_DATAQUERY_SINGLEAUTHORLIST_FIELDS:
                return UserTypeResolver::class;
        }

        return parent::getTypeResolverClass($module);
    }

    public function getQueryInputOutputHandlerClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_DATAQUERY_CONTENTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_POSTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_USERLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_TAGLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_AUTHORPOSTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_AUTHORCONTENTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_TAGPOSTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_TAGCONTENTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_SINGLEAUTHORLIST_FIELDS:
                return ListQueryInputOutputHandler::class;
        }

        return parent::getQueryInputOutputHandlerClass($module);
    }

    protected function getMutableonrequestDataloadQueryArgs(array $module, array &$props): array
    {
        $ret = parent::getMutableonrequestDataloadQueryArgs($module, $props);

        switch ($module[1]) {
            case self::MODULE_DATALOAD_DATAQUERY_AUTHORPOSTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_AUTHORCONTENTLIST_FIELDS:
                PoP_Module_Processor_CustomSectionBlocksUtils::addDataloadqueryargsAuthorcontent($ret);
                break;

            case self::MODULE_DATALOAD_DATAQUERY_TAGPOSTLIST_FIELDS:
                PoP_Module_Processor_CustomSectionBlocksUtils::addDataloadqueryargsTagcontent($ret);
                break;

            case self::MODULE_DATALOAD_DATAQUERY_TAGCONTENTLIST_FIELDS:
                PoP_Application_SectionUtils::addDataloadqueryargsAllcontentBysingletag($ret);
                break;

            case self::MODULE_DATALOAD_DATAQUERY_SINGLEAUTHORLIST_FIELDS:
                PoP_Module_Processor_CustomSectionBlocksUtils::addDataloadqueryargsSingleauthors($ret);
                break;
        }

        return $ret;
    }
    protected function getImmutableDataloadQueryArgs(array $module, array &$props): array
    {
        $ret = parent::getImmutableDataloadQueryArgs($module, $props);

        switch ($module[1]) {
            case self::MODULE_DATALOAD_DATAQUERY_POSTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_AUTHORPOSTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_TAGPOSTLIST_FIELDS:
                if ($categories = gdDataloadAllcontentCategories()) {
                    $ret['category-in'] = $categories;
                }
                break;

            case self::MODULE_DATALOAD_DATAQUERY_CONTENTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_AUTHORCONTENTLIST_FIELDS:
            case self::MODULE_DATALOAD_DATAQUERY_TAGCONTENTLIST_FIELDS:
                PoP_Application_SectionUtils::addDataloadqueryargsAllcontent($ret);
                break;
        }

        return $ret;
    }

    public function getFilterSubmodule(array $module): ?array
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_DATAQUERY_CONTENTLIST_FIELDS:
                return [PoP_Module_Processor_CustomFilters::class, PoP_Module_Processor_CustomFilters::MODULE_FILTER_CONTENT];

            case self::MODULE_DATALOAD_DATAQUERY_POSTLIST_FIELDS:
                return [PoP_Module_Processor_CustomFilters::class, PoP_Module_Processor_CustomFilters::MODULE_FILTER_POSTS];

            case self::MODULE_DATALOAD_DATAQUERY_TAGLIST_FIELDS:
                return [PoP_Module_Processor_CustomFilters::class, PoP_Module_Processor_CustomFilters::MODULE_FILTER_TAGS];

            case self::MODULE_DATALOAD_DATAQUERY_USERLIST_FIELDS:
                return [PoP_Module_Processor_CustomFilters::class, PoP_Module_Processor_CustomFilters::MODULE_FILTER_USERS];

            case self::MODULE_DATALOAD_DATAQUERY_AUTHORPOSTLIST_FIELDS:
                return [PoP_Module_Processor_CustomFilters::class, PoP_Module_Processor_CustomFilters::MODULE_FILTER_AUTHORPOSTS];

            case self::MODULE_DATALOAD_DATAQUERY_AUTHORCONTENTLIST_FIELDS:
                return [PoP_Module_Processor_CustomFilters::class, PoP_Module_Processor_CustomFilters::MODULE_FILTER_AUTHORCONTENT];

            case self::MODULE_DATALOAD_DATAQUERY_TAGPOSTLIST_FIELDS:
                return [PoP_Module_Processor_CustomFilters::class, PoP_Module_Processor_CustomFilters::MODULE_FILTER_TAGPOSTS];

            case self::MODULE_DATALOAD_DATAQUERY_TAGCONTENTLIST_FIELDS:
                return [PoP_Module_Processor_CustomFilters::class, PoP_Module_Processor_CustomFilters::MODULE_FILTER_TAGCONTENT];
        }

        return parent::getFilterSubmodule($module);
    }
}



