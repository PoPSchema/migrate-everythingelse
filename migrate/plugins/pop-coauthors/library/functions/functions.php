<?php
use PoP\Hooks\Facades\HooksAPIFacade;

/**
 * Override function to get the authors of a post
 */
HooksAPIFacade::getInstance()->addFilter('gdGetPostauthors', 'gdGdGetPostauthors', 10, 2);
function gdGdGetPostauthors($authors, $post_id)
{
    $pluginapi = PoP_Coauthors_APIFactory::getInstance();
    return $pluginapi->getCoauthors($post_id, ['return-type' => POP_RETURNTYPE_IDS]);
}
