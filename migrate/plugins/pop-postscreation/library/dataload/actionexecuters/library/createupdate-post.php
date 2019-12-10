<?php

class GD_CreateUpdate_Post extends GD_CreateUpdate_PostBase
{
    protected function showCategories()
    {
        return !empty(PoP_Application_Utils::getContentpostsectionCats());
    }
}
