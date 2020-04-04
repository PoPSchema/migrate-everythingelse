<?php
namespace PoP\UserRoles;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;
use PoP\ComponentModel\State\ApplicationState;

HooksAPIFacade::getInstance()->addFilter(
    \PoP\ComponentModel\ModelInstance\ModelInstance::HOOK_COMPONENTS_RESULT, 
    function ($components) {
        $vars = ApplicationState::getVars();
        switch ($vars['nature']) {
            case UserRouteNatures::USER:
                $user_id = $vars['routing-state']['queried-object-id'];

                // Author: it may depend on its role
                $component_types = HooksAPIFacade::getInstance()->applyFilters(
                    '\PoP\ComponentModel\ModelInstanceProcessor_Utils:components_from_vars:type:userrole',
                    array(
                        POP_MODELINSTANCECOMPONENTTYPE_AUTHOR_ROLE,
                    )
                );
                if (in_array(POP_MODELINSTANCECOMPONENTTYPE_AUTHOR_ROLE, $component_types)) {
                    $components[] = TranslationAPIFacade::getInstance()->__('user role:', 'pop-engine').\PoP\UserRoles\Utils::getTheUserRole($user_id);
                }
                break;
        }

        return $components;
    }
);
