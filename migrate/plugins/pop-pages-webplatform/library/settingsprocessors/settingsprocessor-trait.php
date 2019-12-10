<?php

trait PoPWebPlatform_Pages_Module_SettingsProcessor_Trait
{
    public function silentDocument()
    {
        return array(
            POP_PAGES_ROUTE_LOADERS_PAGES_FIELDS => true,
            POP_PAGES_ROUTE_LOADERS_PAGES_LAYOUTS => true,
        );
    }
}
