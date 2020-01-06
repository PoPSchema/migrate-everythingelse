<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\Instances\InstanceManagerFacade;

class PoP_UserLogin_DataLoad_DataloaderHooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'PoP\ComponentModel\Engine:moveEntriesUnderDBName:dbName-dataFields',
            array($this, 'moveEntriesUnderDBName'),
            10,
            2
        );
    }

    public function moveEntriesUnderDBName($dbname_datafields, $typeResolver)
    {
        $instanceManager = InstanceManagerFacade::getInstance();
        $typeDataLoaderClass = $typeResolver->getTypeDataLoaderClass();
        $typeDataLoader = $instanceManager->getInstance($typeDataLoaderClass);
        // if ($dataquery_name = $typeDataLoader->getDataquery()) {
        //     // The data-fields include both state-less/cacheable and state-full/non-cacheable fields
        //     // The typeResolver knows what fields are non-cacheable. Get these and return the results in another array
        //     $dataquery_manager = \PoP\ComponentModel\DataQueryManagerFactory::getInstance();
        //     $dataquery = $dataquery_manager->get($dataquery_name);
        //     if ($userstate_data_fields = $dataquery->getProperty(POP_DATAQUERYPROPERTY_LOGGEDINUSERFIELDS)) {
        //         $dbname_datafields['userstate'] = $userstate_data_fields;
        //     }
        // }
        return $dbname_datafields;
    }
}

/**
 * Initialize
 */
new PoP_UserLogin_DataLoad_DataloaderHooks();
