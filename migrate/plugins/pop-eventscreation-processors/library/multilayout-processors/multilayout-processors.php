<?php
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\Events\TypeResolvers\EventTypeResolver;

class PoP_EventsCreation_Multilayout_Processor extends PoP_Application_Multilayout_ProcessorBase
{
    public function addLayoutModules(&$layouts, $handle, $format = '')
    {
        $pluginapi = PoP_Events_APIFactory::getInstance();
        $event_post_type = $pluginapi->getEventPostType();

        // Only if this post type is shown in All Content
        $cmsapplicationpostsapi = \PoP\Application\PostsFunctionAPIFactory::getInstance();
        if (in_array($event_post_type, $cmsapplicationpostsapi->getAllcontentPostTypes())) {
            switch ($handle) {
                case POP_MULTILAYOUT_HANDLE_POSTCONTENT:
                    $pasts = array(
                        POP_FORMAT_TABLE => [GD_EM_Module_Processor_CustomPreviewPostLayouts::class, GD_EM_Module_Processor_CustomPreviewPostLayouts::MODULE_LAYOUT_PREVIEWPOST_PASTEVENT_EDIT],
                    );
                    $defaults = array( // <= Future and Current Events
                        POP_FORMAT_TABLE => [GD_EM_Module_Processor_CustomPreviewPostLayouts::class, GD_EM_Module_Processor_CustomPreviewPostLayouts::MODULE_LAYOUT_PREVIEWPOST_EVENT_EDIT],
                    );

                    // TODO: Split past/non-past on a level below, using the conditionalOnDataFieldSubmodule
                    // Temporarily commented (code `$event_post_type.'-'.POP_EVENTS_SCOPE_PAST` belongs to the old way of doing things, doesn't work anymore) 
                    // if ($layout = $pasts[$format]) {
                    //     $layouts[$event_post_type.'-'.POP_EVENTS_SCOPE_PAST] = $layout;
                    // }
                    if ($layout = $defaults[$format]) {
                        $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
                        $field = $fieldQueryInterpreter->getField(
                            'equals', 
                            [
                                'value1' => $fieldQueryInterpreter->createFieldArgValueAsFieldFromFieldName('__typename'), 
                                'value2' => EventTypeResolver::NAME,
                            ]
                        );
                        $layouts[$field] = $layout;
                    }
                    break;
            }
        }
    }
}

/**
 * Initialization
 */
new PoP_EventsCreation_Multilayout_Processor();
