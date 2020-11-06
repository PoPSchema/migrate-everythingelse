<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\Instances\InstanceManagerFacade;

HooksAPIFacade::getInstance()->addAction(
    'popcms:init',
    'gdQtInitsettings'
);
function gdQtInitsettings()
{
    $instanceManager = InstanceManagerFacade::getInstance();
    /** @var GD_Settings */
    $actionExecuterSettings = $instanceManager->getInstance(GD_Settings::class);
    $actionExecuterSettings->add(
    	[GD_QT_Module_Processor_SelectFormInputs::class, GD_QT_Module_Processor_SelectFormInputs::MODULE_QT_FORMINPUT_LANGUAGE],
    	new GD_QT_Settings_UrlOperator_Language()
    );
}
