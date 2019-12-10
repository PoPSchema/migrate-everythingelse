<?php

trait PoPWebPlatform_Taxonomies_Module_SettingsProcessor_Trait
{
    public function silentDocument()
    {
        return array(
            POP_TAXONOMIES_ROUTE_LOADERS_TAGS_FIELDS => true,
            POP_TAXONOMIES_ROUTE_LOADERS_TAGS_LAYOUTS => true,
        );
    }
}
