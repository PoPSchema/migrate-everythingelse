<?php
namespace PoP\Theme;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Application\QueryInputOutputHandlers\ParamConstants;

class PoP_Theme_Meta_Hooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            '\PoP\ComponentModel\Engine:site-meta',
            array($this, 'getSiteMeta')
        );
    }

    public function getSiteMeta($meta)
    {
        if (\PoP\ComponentModel\Utils::fetchingSite()) {
            $vars = \PoP\ComponentModel\Engine_Vars::getVars();

            // Send the current selected theme back
            if ($vars['theme']) {
                $meta[ParamConstants::PARAMS][GD_URLPARAM_THEME] = $vars['theme'];
            }
            if ($vars['thememode']) {
                $meta[ParamConstants::PARAMS][GD_URLPARAM_THEMEMODE] = $vars['thememode'];
            }
            if ($vars['themestyle']) {
                $meta[ParamConstants::PARAMS][GD_URLPARAM_THEMESTYLE] = $vars['themestyle'];
            }

            $pushurlprops = array();

            // Theme: send only when it's not the default one (so the user can still see/copy/share the embed/print URL)
            if ($vars['theme'] && !$vars['theme-isdefault']) {
                $pushurlprops[GD_URLPARAM_THEME] = $vars['theme'];
            }
            if ($vars['thememode'] && !$vars['thememode-isdefault']) {
                $pushurlprops[GD_URLPARAM_THEMEMODE] = $vars['thememode'];
            }
            if ($vars['themestyle'] && !$vars['themestyle-isdefault']) {
                $pushurlprops[GD_URLPARAM_THEMESTYLE] = $vars['themestyle'];
            }

            if ($pushurlprops) {
                $meta[ParamConstants::PUSHURLATTS] = array_merge(
                    $meta[ParamConstants::PUSHURLATTS] ?? array(),
                    $pushurlprops
                );
            }
        }

        return $meta;
    }
}

/**
 * Initialization
 */
new PoP_Theme_Meta_Hooks();
