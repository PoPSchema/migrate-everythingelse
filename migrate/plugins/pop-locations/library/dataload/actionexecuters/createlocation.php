<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;

class GD_DataLoad_ActionExecuter_CreateLocation implements \PoP\ComponentModel\ActionExecuterInterface
{
    public function execute(&$data_properties)
    {
        // If the post has been submitted, execute the Gravity Forms shortcode
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            // Allow EM PoP to initialize the field names as it needs them to populate the object in function getPost($validate = true),
            // in file plugins/events-manager/classes/em-location.php
            HooksAPIFacade::getInstance()->doAction('create_location');

            $pluginapi = PoP_Locations_APIFactory::getInstance();
            $location = $pluginapi->getNewLocationObject();
                
            // Load from $_REQUEST and Validate
            if ($pluginapi->getPost($location)  && $pluginapi->save($location)) { //EM_location gets the location if submitted via POST and validates it (safer than to depend on JS)
                // Save the result for some module to incorporate it into the query args
                $gd_dataload_actionexecution_manager = \PoP\ComponentModel\ActionExecutionManagerFactory::getInstance();
                $gd_dataload_actionexecution_manager->setResult(self::class, $pluginapi->getPostId($location));

                return array(
                    ResponseConstants::SUCCESS => true
                );
            } else {
                return array(
                    ResponseConstants::ERRORSTRINGS => $pluginapi->getErrors($location)
                );
            }
        }

        return null;
    }
}
    
