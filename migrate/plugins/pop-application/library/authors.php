<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;
use PoP\ComponentModel\Misc\RequestUtils;

/**
 * Return the author of the post (to be overriden by Co-Authors plus)
 */
function gdGetPostauthors($post_id)
{
    $postTypeAPI = PostTypeAPIFacade::getInstance();
    return HooksAPIFacade::getInstance()->applyFilters(
    	'gdGetPostauthors',
    	array($postTypeAPI->getAuthorID($post_id)),
    	$post_id
    );
}

function getAuthorProfileUrl($author)
{
    $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
    $url = $cmsusersapi->getUserURL($author);
    return RequestUtils::addRoute($url, POP_ROUTE_DESCRIPTION);
}

/**
 * Change Author permalink from 'author' to 'u'
 */
HooksAPIFacade::getInstance()->addFilter('author-base', function($authorBase) {
	return 'u';
});
