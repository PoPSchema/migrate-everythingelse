<?php

use PoP\ComponentModel\Facades\Instances\InstanceManagerFacade;

$instanceManager = InstanceManagerFacade::getInstance();
$instanceManager->overrideClass(
    GD_DataLoad_ActionExecuter_NewsletterSubscription::class,
    GD_DataLoad_ActionExecuter_GravityForms::class
);
$instanceManager->overrideClass(
    GD_DataLoad_ActionExecuter_NewsletterUnsubscription::class,
    GD_GF_DataLoad_ActionExecuter_NewsletterUnsubscription::class
);
