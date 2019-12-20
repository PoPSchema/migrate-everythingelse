<?php
use PoP\Posts\Facades\PostTypeAPIFacade;

class PoPTheme_Wassup_AE_SpecialSinglePost extends PoP_UserPreferences_SimpleProcessorAutomatedEmailsBase
{
    public function getRoute()
    {
        return POP_COMMONAUTOMATEDEMAILS_ROUTE_SINGLEPOST_SPECIAL;
    }

    protected function getPreferenceonUsersValue()
    {
        return POP_USERPREFERENCES_EMAILDIGESTS_SPECIALPOSTS;
    }
    
    protected function getSubject()
    {
        
        // The post id is passed through param pid
        $cmspostsapi = PostTypeAPIFacade::getInstance();
        return $cmspostsapi->getTitle($_REQUEST[POP_INPUTNAME_POSTID]);
    }
}

/**
 * Initialization
 */
new PoPTheme_Wassup_AE_SpecialSinglePost();
