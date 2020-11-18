<?php

use PoP\ComponentModel\Facades\Instances\InstanceManagerFacade;
use PoPSitesWassup\GravityFormsMutations\MutationResolverBridges\GravityFormsComponentMutationResolverBridge;

$instanceManager = InstanceManagerFacade::getInstance();
$instanceManager->overrideClass(
    GD_DataLoad_ActionExecuter_ShareByEmail::class,
    GravityFormsComponentMutationResolverBridge::class
);
