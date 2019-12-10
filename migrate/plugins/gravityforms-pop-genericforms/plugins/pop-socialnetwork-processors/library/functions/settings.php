<?php

use PoP\ComponentModel\Facades\Instances\InstanceManagerFacade;

$instanceManager = InstanceManagerFacade::getInstance();
$instanceManager->overrideClass(
    GD_DataLoad_ActionExecuter_ContactUser::class,
    GD_DataLoad_ActionExecuter_GravityForms::class
);
