<?php

class PoPTheme_Wassup_DataQuery_PostHook extends \PoP\Posts\DataQuery_PostHookBase
{
    public function getNoCacheFields()
    {
        return array(
            'userpostactivity-count',
        );
    }

    public function getLazyLayouts()
    {
        return array(
            'referencedby-lazy' => array(
                POP_FORMAT_DETAILS => [Wassup_Module_Processor_WidgetWrappers::class, Wassup_Module_Processor_WidgetWrappers::MODULE_WIDGETWRAPPER_REFERENCEDBY_APPENDTOSCRIPT_DETAILS],
                POP_FORMAT_FULLVIEW => [Wassup_Module_Processor_WidgetWrappers::class, Wassup_Module_Processor_WidgetWrappers::MODULE_WIDGETWRAPPER_REFERENCEDBY_APPENDTOSCRIPT_FULLVIEW],
                POP_FORMAT_SIMPLEVIEW => [Wassup_Module_Processor_WidgetWrappers::class, Wassup_Module_Processor_WidgetWrappers::MODULE_WIDGETWRAPPER_REFERENCEDBY_APPENDTOSCRIPT_SIMPLEVIEW],
                'default' => [Wassup_Module_Processor_WidgetWrappers::class, Wassup_Module_Processor_WidgetWrappers::MODULE_WIDGETWRAPPER_REFERENCEDBY_APPENDTOSCRIPT_SIMPLEVIEW],
            ),
            'highlights-lazy' => array(
                POP_FORMAT_DETAILS => [Wassup_Module_Processor_WidgetWrappers::class, Wassup_Module_Processor_WidgetWrappers::MODULE_WIDGETWRAPPER_HIGHLIGHTS_APPENDTOSCRIPT_DETAILS],
                POP_FORMAT_FULLVIEW => [Wassup_Module_Processor_WidgetWrappers::class, Wassup_Module_Processor_WidgetWrappers::MODULE_WIDGETWRAPPER_HIGHLIGHTS_APPENDTOSCRIPT_FULLVIEW],
                POP_FORMAT_SIMPLEVIEW => [Wassup_Module_Processor_WidgetWrappers::class, Wassup_Module_Processor_WidgetWrappers::MODULE_WIDGETWRAPPER_HIGHLIGHTS_APPENDTOSCRIPT_SIMPLEVIEW],
                'default' => [Wassup_Module_Processor_WidgetWrappers::class, Wassup_Module_Processor_WidgetWrappers::MODULE_WIDGETWRAPPER_HIGHLIGHTS_APPENDTOSCRIPT_SIMPLEVIEW],
            ),
        );
    }
}

/**
 * Initialization
 */
new PoPTheme_Wassup_DataQuery_PostHook();
