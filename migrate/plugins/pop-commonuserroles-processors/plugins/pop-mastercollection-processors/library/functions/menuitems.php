<?php
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addFilter('gdAuthorParentpageid', 'gdUreAuthorParentpageidImpl', 10, 2);
function gdUreAuthorParentpageidImpl($pageid, $author_id = null)
{
    if (is_null($author_id)) {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $author_id = $vars['routing-state']['queried-object-id'];
    }

    if (gdUreIsOrganization($author_id)) {
        return POP_COMMONUSERROLES_ROUTE_ORGANIZATIONS;
    } elseif (gdUreIsIndividual($author_id)) {
        return POP_COMMONUSERROLES_ROUTE_INDIVIDUALS;
    }

    return $pageid;
}
