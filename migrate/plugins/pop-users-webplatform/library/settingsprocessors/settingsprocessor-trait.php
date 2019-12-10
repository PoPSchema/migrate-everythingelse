<?php

trait PoPWebPlatform_Users_Module_SettingsProcessor_Trait
{
    public function silentDocument()
    {
        return array(
            POP_USERS_ROUTE_LOADERS_USERS_FIELDS => true,
            POP_USERS_ROUTE_LOADERS_USERS_LAYOUTS => true,
        );
    }
}
