<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

class PoPTheme_AddHighlights_Processors_ContentHooks
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
            $postTypeAPI = PostTypeAPIFacade::getInstance();
            if ($postTypeAPI->getPostType($post_id) == POP_ADDHIGHLIGHTS_POSTTYPE_HIGHLIGHT) {
                if (($module == [PoP_Module_Processor_Contents::class, PoP_Module_Processor_Contents::MODULE_CONTENT_SINGLE])) {
                    return [PoP_Module_Processor_SingleContentInners::class, PoP_Module_Processor_SingleContentInners::MODULE_CONTENTINNER_HIGHLIGHTSINGLE];
                } elseif (($module == [PoP_Module_Processor_Contents::class, PoP_Module_Processor_Contents::MODULE_CONTENT_USERPOSTINTERACTION])) {
                    return [PoP_Module_Processor_SingleContentInners::class, PoP_Module_Processor_SingleContentInners::MODULE_CONTENTINNER_USERHIGHLIGHTPOSTINTERACTION];
                }
            }
        }

        return $inner;
    }
}

/**
 * Initialization
 */
new PoPTheme_AddHighlights_Processors_ContentHooks();
