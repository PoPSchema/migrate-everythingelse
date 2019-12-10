<?php

class PoPTheme_UserStance_DataQuery_PostHook extends \PoP\Posts\DataQuery_PostHookBase
{
    use PoP_UserLogin_DataQuery_Hook_Trait;
    
    public function getLoggedinuserfields()
    {
        return array(
            'loggedinuser-stances',
            'has-loggedinuser-stances',
            'editstance-url',
        );
    }

    public function getLazyLayouts()
    {
        return array(
            'stances-lazy' => array(
                POP_FORMAT_DETAILS => [UserStance_Module_Processor_WidgetWrappers::class, UserStance_Module_Processor_WidgetWrappers::MODULE_WIDGETWRAPPER_STANCES_APPENDTOSCRIPT_DETAILS],
                POP_FORMAT_FULLVIEW => [UserStance_Module_Processor_WidgetWrappers::class, UserStance_Module_Processor_WidgetWrappers::MODULE_WIDGETWRAPPER_STANCES_APPENDTOSCRIPT_FULLVIEW],
                'default' => [UserStance_Module_Processor_WidgetWrappers::class, UserStance_Module_Processor_WidgetWrappers::MODULE_WIDGETWRAPPER_STANCES_APPENDTOSCRIPT_FULLVIEW],
            ),
            'createstancebutton-lazy' => array(
                'default' => [UserStance_Module_Processor_WidgetWrappers::class, UserStance_Module_Processor_WidgetWrappers::MODULE_BUTTONWRAPPER_STANCE_CREATEORUPDATE_APPENDTOSCRIPT],
            ),
        );
    }
}

/**
 * Initialization
 */
new PoPTheme_UserStance_DataQuery_PostHook();
