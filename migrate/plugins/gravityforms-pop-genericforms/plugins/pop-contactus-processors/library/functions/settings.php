<?php

use PoP\ComponentModel\Facades\Instances\InstanceManagerFacade;
use PoPSitesWassup\ContactUsMutations\MutationResolverBridges\ContactUsComponentMutationResolverBridge;
use PoPSitesWassup\GravityFormsMutations\MutationResolverBridges\GravityFormsComponentMutationResolverBridge;

$instanceManager = InstanceManagerFacade::getInstance();
$instanceManager->overrideClass(
    ContactUsComponentMutationResolverBridge::class,
    GravityFormsComponentMutationResolverBridge::class
);
