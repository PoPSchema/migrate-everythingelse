<?php

class GD_GF_DataLoad_ActionExecuter_NewsletterUnsubscription extends GD_DataLoad_ActionExecuter_NewsletterUnsubscription
{
    public function getMutationResolverClass(): string
    {
        return PoP_GF_UnsubscribeFromNewsletter::class;
    }
}

