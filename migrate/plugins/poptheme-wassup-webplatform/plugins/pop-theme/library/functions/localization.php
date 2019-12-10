<?php
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addFilter('gd_jquery_constants', 'popthemeWassupJqueryConstants');
function popthemeWassupJqueryConstants($jqueryConstants)
{
    $jqueryConstants['URLPARAM_THEMEMODE'] = GD_URLPARAM_THEMEMODE;
    $jqueryConstants['URLPARAM_THEMESTYLE'] = GD_URLPARAM_THEMESTYLE;

    $jqueryConstants['THEMEMODE_WASSUP_EMBED'] = GD_THEMEMODE_WASSUP_EMBED;
    $jqueryConstants['THEMEMODE_WASSUP_PRINT'] = GD_THEMEMODE_WASSUP_PRINT;

    $vars = \PoP\ComponentModel\Engine_Vars::getVars();
    $jqueryConstants['THEMESTYLE'] = $vars['themestyle-isdefault'] ? '' : $vars['themestyle'];
    return $jqueryConstants;
}
