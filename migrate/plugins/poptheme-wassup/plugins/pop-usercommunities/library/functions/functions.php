<?php
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addFilter('PoP_Module_Processor_PageTabPageSections:getModuleExtraInterceptUrls', 'gdUreAddSourceParamPagesections');
HooksAPIFacade::getInstance()->addFilter('PoP_Module_Processor_TabPanePageSections:getModuleExtraInterceptUrls', 'gdUreAddSourceParamPagesections');
function gdUreAddSourceParamPagesections($url)
{
    $vars = \PoP\ComponentModel\Engine_Vars::getVars();
    if ($vars['routing-state']['is-user']) {
        $author = $vars['routing-state']['queried-object-id'];
        return gdUreAddSourceParam($url, $author);
    }

    return $url;
}
