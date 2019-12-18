<?php
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\LocationPosts\TypeResolvers\LocationPostTypeResolver;

class PoP_LocationPostsCreation_Multilayout_Processor extends PoP_Application_Multilayout_ProcessorBase
{
    public function addLayoutModules(&$layouts, $handle, $format = '')
    {
        switch ($handle) {
            case POP_MULTILAYOUT_HANDLE_POSTCONTENT:
                $location_modules = array();
                if ($handle == POP_MULTILAYOUT_HANDLE_POSTCONTENT) {
                    $location_modules = array(
                        POP_FORMAT_TABLE => [PoP_LocationPostsCreation_Module_Processor_CustomPreviewPostLayouts::class, PoP_LocationPostsCreation_Module_Processor_CustomPreviewPostLayouts::MODULE_LAYOUT_PREVIEWPOST_LOCATIONPOST_EDIT],
                    );
                }

                if ($layout = $location_modules[$format]) {
                    $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
                    $field = $fieldQueryInterpreter->getField(
                        'equals', 
                        [
                            'value1' => $fieldQueryInterpreter->createFieldArgValueAsFieldFromFieldName('__typename'), 
                            'value2' => LocationPostTypeResolver::NAME,
                        ]
                    );
                    $layouts[$field] = $layout;
                }
                break;
        }
    }
}

/**
 * Initialization
 */
new PoP_LocationPostsCreation_Multilayout_Processor();
