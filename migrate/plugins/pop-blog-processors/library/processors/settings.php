<?php
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

$moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
$moduleprocessor_manager->overrideProcessorClass(
    PoP_Posts_Module_Processor_FieldDataloads::class,
    PoP_Blog_Module_Processor_FieldDataloads::class,
    [
        PoP_Posts_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_POSTLIST_FIELDS,
    ]
);
$moduleprocessor_manager->overrideProcessorClass(
    PoP_Users_Module_Processor_FieldDataloads::class,
    PoP_Blog_Module_Processor_FieldDataloads::class,
    [
        PoP_Users_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_USERLIST_FIELDS,
    ]
);
$moduleprocessor_manager->overrideProcessorClass(
    PoP_Users_Posts_Module_Processor_FieldDataloads::class,
    PoP_Blog_Module_Processor_FieldDataloads::class,
    [
        PoP_Users_Posts_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_AUTHORPOSTLIST_FIELDS,
    ]
);
$moduleprocessor_manager->overrideProcessorClass(
    PoP_Taxonomies_Module_Processor_FieldDataloads::class,
    PoP_Blog_Module_Processor_FieldDataloads::class,
    [
        PoP_Taxonomies_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_TAGLIST_FIELDS,
        PoP_Taxonomies_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_TAGPOSTLIST_FIELDS,
    ]
);


