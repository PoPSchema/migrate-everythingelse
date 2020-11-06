<?php

class GD_DataLoad_ActionExecuter_NewsletterUnsubscription extends GD_DataLoad_FormActionExecuterBase
{
    public function getMutationResolverClass(): string
    {
        return PoP_UnsubscribeFromNewsletter::class;
    }
}

