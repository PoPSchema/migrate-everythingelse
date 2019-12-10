<?php

trait PoPWebPlatform_Posts_Module_SettingsProcessor_Trait
{
    public function silentDocument()
    {
        return array(
            POP_POSTS_ROUTE_LOADERS_POSTS_FIELDS => true,
            POP_POSTS_ROUTE_LOADERS_POSTS_LAYOUTS => true,
        );
    }
}
