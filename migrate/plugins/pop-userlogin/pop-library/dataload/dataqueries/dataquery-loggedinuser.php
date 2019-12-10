<?php

define('POP_DATAQUERYPROPERTY_LOGGEDINUSERFIELDS', 'loggedinuser-fields');

trait PoP_UserLogin_DataQuery_Hook_Trait
{
    public function __construct()
    {
        parent::__construct();

        $name = $this->getDataqueryName();

        // Add the loggedinuser-fields property to the referenced dataquery
        $dataquery_manager = \PoP\ComponentModel\DataQueryManagerFactory::getInstance();
        $dataquery = $dataquery_manager->get($name);
        $dataquery->addProperty(POP_DATAQUERYPROPERTY_LOGGEDINUSERFIELDS, $this->getLoggedinuserfields());
    }

    public function getAllowedFields()
    {

        // Add the loggedinuser-fields property to the allowed fields
        return array_unique(
            array_merge(
                parent::getAllowedFields(),
                $this->getLoggedinuserfields()
            )
        );
    }
    public function getLoggedinuserfields()
    {
        return array();
    }
}
