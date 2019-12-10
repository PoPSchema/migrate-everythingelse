<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addFilter('UserStance_Module_Processor_CustomCarouselControls:authorstances:titlelink', 'gdUreAddSourceParamPagesections');

HooksAPIFacade::getInstance()->addFilter('UserStance_Module_Processor_CustomCarouselControls:authorstances:title', 'gdUserstanceUreTitlemembers');
function gdUserstanceUreTitlemembers($title)
{
    $vars = \PoP\ComponentModel\Engine_Vars::getVars();
    $author = $vars['routing-state']['queried-object-id'];
    if (gdUreIsCommunity($author)) {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        if ($vars['source'] == GD_URLPARAM_URECONTENTSOURCE_COMMUNITY) {
            $title .= TranslationAPIFacade::getInstance()->__(' + Members', 'pop-userstance-processors');
        }
    }

    return $title;
}
