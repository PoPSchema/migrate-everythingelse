<?php
use PoP\Translation\Facades\TranslationAPIFacade;

abstract class PoP_Module_Processor_EventTypeaheadComponentFormInputsBase extends PoP_Module_Processor_PostTypeaheadComponentFormInputsBase
{
    protected function getThumbprintQuery(array $module, array &$props)
    {
        $ret = parent::getThumbprintQuery($module, $props);

        $pluginapi = PoP_Events_APIFactory::getInstance();
        $ret['post-types'] = [$pluginapi->getEventPostType()];
        
        return $ret;
    }

    protected function getPendingMsg(array $module)
    {
        return TranslationAPIFacade::getInstance()->__('Loading Events', 'em-popprocessors');
    }
    protected function getNotfoundMsg(array $module)
    {
        return TranslationAPIFacade::getInstance()->__('No Events found', 'em-popprocessors');
    }
}
