<?php

abstract class PoP_Module_Processor_AppendCommentLayoutsBase extends PoPEngine_QueryDataModuleProcessorBase
{
    public function getTemplateResource(array $module, array &$props): ?array
    {
        return [PoP_CoreProcessors_TemplateResourceLoaderProcessor::class, PoP_CoreProcessors_TemplateResourceLoaderProcessor::RESOURCE_SCRIPT_APPENDCOMMENT];
    }
    
    public function getDataFields(array $module, array &$props): array
    {
        $ret = parent::getDataFields($module, $props);

        $ret[] = 'post-id';
        $ret[] = 'parent';
        
        return $ret;
    }
    
    public function getImmutableConfiguration(array $module, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($module, $props);

        $ret['post-dbkey'] = \PoP\Posts\TypeResolvers\PostTypeResolver::TYPE_COLLECTION_NAME;
        $ret[GD_JS_CLASSES][GD_JS_APPENDABLE] = 'comments';
        
        return $ret;
    }
}
