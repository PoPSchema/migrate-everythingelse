<?php

class GD_DataLoad_ActionExecuter_ContactUs extends GD_DataLoad_FormActionExecuterBase
{
    public function getMutationResolverClass(): string
    {
        return PoP_ActionExecuterInstance_ContactUs::class;
    }
}

