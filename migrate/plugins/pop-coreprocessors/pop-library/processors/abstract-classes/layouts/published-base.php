<?php
use PoP\Translation\Facades\TranslationAPIFacade;

abstract class PoP_Module_Processor_PostStatusDateLayoutsBase extends PoPEngine_QueryDataModuleProcessorBase
{
    public function getTemplateResource(array $module, array &$props): ?array
    {
        return [PoP_CoreProcessors_TemplateResourceLoaderProcessor::class, PoP_CoreProcessors_TemplateResourceLoaderProcessor::RESOURCE_LAYOUT_POSTSTATUSDATE];
    }

    public function getDataFields(array $module, array &$props): array
    {
        return array('date', 'status');
    }

    public function getImmutableConfiguration(array $module, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($module, $props);
    
        $ret[GD_JS_TITLES] = array(
            POP_POSTSTATUS_PUBLISHED => TranslationAPIFacade::getInstance()->__('Published', 'pop-coreprocessors'),
            POP_POSTSTATUS_PENDING => TranslationAPIFacade::getInstance()->__('Pending', 'pop-coreprocessors'),
            POP_POSTSTATUS_DRAFT => TranslationAPIFacade::getInstance()->__('Draft', 'pop-coreprocessors'),
        );
        
        return $ret;
    }
}
