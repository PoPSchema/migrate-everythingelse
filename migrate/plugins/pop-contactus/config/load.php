<?php
use PoP\Hooks\Facades\HooksAPIFacade;

require_once 'routes.php';

// High priority: allow the Theme and other plug-ins to set the values in advance.
HooksAPIFacade::getInstance()->addAction(
    'popcms:init', 
    'popContactusInitConstants', 
    10000
);
function popContactusInitConstants()
{
    include_once 'constants.php';
}
