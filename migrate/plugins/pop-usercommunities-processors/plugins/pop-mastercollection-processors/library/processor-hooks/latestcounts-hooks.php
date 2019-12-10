<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class UREPoP_RoleProcessors_LatestCounts_Hooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'latestcounts:author:classes',
            array($this, 'getClasses')
        );
    }

    public function getClasses($classes)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $author = $vars['routing-state']['queried-object-id'];

        // Add all the members of the community, if the author is a community, and we're on the Community+Members page
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        if (gdUreIsCommunity($author) && $vars['source'] == GD_URLPARAM_URECONTENTSOURCE_COMMUNITY) {
            if ($members = gdUreGetActivecontributingcontentcommunitymembers($author)) {
                foreach ($members as $member) {
                    $classes[] = 'author'.$member;
                }
            }
        }
        return $classes;
    }
}

/**
 * Initialization
 */
new UREPoP_RoleProcessors_LatestCounts_Hooks();
