<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoPTheme_UserStance_ContentHooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'PoP_Module_Processor_Contents:inner_module',
            array($this, 'contentInner'),
            10,
            2
        );
    }

    public function contentInner($inner, array $module)
    {
        if ($module == [PoP_Module_Processor_Contents::class, PoP_Module_Processor_Contents::MODULE_CONTENT_SINGLE] || $module == [PoP_Module_Processor_Contents::class, PoP_Module_Processor_Contents::MODULE_CONTENT_USERPOSTINTERACTION]) {
            $vars = \PoP\ComponentModel\Engine_Vars::getVars();
            $post_id = $vars['routing-state']['queried-object-id'];
            $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
            if ($cmspostsapi->getPostType($post_id) == POP_USERSTANCE_POSTTYPE_USERSTANCE) {
                if (($module == [PoP_Module_Processor_Contents::class, PoP_Module_Processor_Contents::MODULE_CONTENT_SINGLE])) {
                    return [UserStance_Module_Processor_SingleContentInners::class, UserStance_Module_Processor_SingleContentInners::MODULE_CONTENTINNER_STANCESINGLE];
                } elseif (($module == [PoP_Module_Processor_Contents::class, PoP_Module_Processor_Contents::MODULE_CONTENT_USERPOSTINTERACTION])) {
                    return [UserStance_Module_Processor_SingleContentInners::class, UserStance_Module_Processor_SingleContentInners::MODULE_CONTENTINNER_USERSTANCEPOSTINTERACTION];
                }
            }
        }
        
        return $inner;
    }
}

/**
 * Initialization
 */
new PoPTheme_UserStance_ContentHooks();
