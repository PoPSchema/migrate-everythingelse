<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Events\Facades\EventTypeAPIFacade;

abstract class PoP_Module_Processor_EventTypeaheadComponentFormInputsBase extends PoP_Module_Processor_PostTypeaheadComponentFormInputsBase
{
    protected function getThumbprintQuery(array $module, array &$props)
    {
        $ret = parent::getThumbprintQuery($module, $props);

        $eventTypeAPI = EventTypeAPIFacade::getInstance();
        $ret['post-types'] = [$eventTypeAPI->getEventPostType()];

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
