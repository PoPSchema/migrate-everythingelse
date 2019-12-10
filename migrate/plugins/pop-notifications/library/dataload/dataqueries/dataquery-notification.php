<?php

define('GD_DATAQUERY_NOTIFICATION', 'notification');

class GD_DataQuery_Notification extends \PoP\ComponentModel\DataQueryBase
{
    public function getName()
    {
        return GD_DATAQUERY_NOTIFICATION;
    }

    public function getObjectidFieldname()
    {
        return 'nid';
    }
}
    
/**
 * Initialize
 */
new GD_DataQuery_Notification();
