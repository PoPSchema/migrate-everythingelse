<?php

trait PoPWebPlatform_Comments_Module_SettingsProcessor_Trait
{
    public function silentDocument()
    {
        return array(
            POP_COMMENTS_ROUTE_LOADERS_COMMENTS_FIELDS => true,
            POP_COMMENTS_ROUTE_LOADERS_COMMENTS_LAYOUTS => true,
        );
    }
}
