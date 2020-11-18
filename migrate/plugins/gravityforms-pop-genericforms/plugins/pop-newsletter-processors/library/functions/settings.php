<?php

use PoP\ComponentModel\Facades\Instances\InstanceManagerFacade;
use PoPSitesWassup\GravityFormsMutations\MutationResolverBridges\GravityFormsComponentMutationResolverBridge;

$instanceManager = InstanceManagerFacade::getInstance();
$instanceManager->overrideClass(
    GD_DataLoad_ActionExecuter_NewsletterSubscription::class,
    GravityFormsComponentMutationResolverBridge::class
);
$instanceManager->overrideClass(
    GD_DataLoad_ActionExecuter_NewsletterUnsubscription::class,
    GD_GF_DataLoad_ActionExecuter_NewsletterUnsubscription::class
);
