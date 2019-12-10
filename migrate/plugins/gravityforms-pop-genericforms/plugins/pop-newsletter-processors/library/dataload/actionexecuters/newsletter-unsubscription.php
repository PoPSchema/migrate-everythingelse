<?php

class GD_GF_DataLoad_ActionExecuter_NewsletterUnsubscription extends GD_DataLoad_ActionExecuter_NewsletterUnsubscription
{
    protected function getInstance()
    {
        return new PoP_GF_UnsubscribeFromNewsletter();
    }
}
    
