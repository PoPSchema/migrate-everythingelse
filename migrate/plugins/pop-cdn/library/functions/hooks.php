<?php
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addFilter('\PoP\ComponentModel\Utils:current_url:remove_params', 'popCdnRemoveUrlparams');
function popCdnRemoveUrlparams($remove_params)
{
    $remove_params[] = GD_URLPARAM_CDNTHUMBPRINT;

    return $remove_params;
}
