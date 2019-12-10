<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;

abstract class GD_DataLoad_ActionExecuter_CreateUpdate_UserBase implements \PoP\ComponentModel\ActionExecuterInterface
{
    public function execute(&$data_properties)
    {
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $createupdate = $this->getCreateupdate();
            $errors = array();
            $action = $createupdate->createOrUpdate($errors, $data_properties);

            if ($errors) {
                return array(
                    ResponseConstants::ERRORSTRINGS => $errors
                );
            }

            // No errors => success
            $ret = array(
                ResponseConstants::SUCCESS => true
            );

            // For the update, gotta return the success string
            if ($action == 'update') {
                // Allow PoP Service Workers to add the attr to avoid the link being served from the browser cache
                $vars = \PoP\ComponentModel\Engine_Vars::getVars();
                $success_string = sprintf(
                    TranslationAPIFacade::getInstance()->__('View your <a href="%s" target="%s" %s>updated profile</a>.', 'pop-application'),
                    getAuthorProfileUrl($vars['global-userstate']['current-user-id']),
                    PoP_Application_Utils::getPreviewTarget(),
                    HooksAPIFacade::getInstance()->applyFilters('GD_DataLoad_ActionExecuter_CreateUpdate_UserBase:success_msg:linkattrs', '')
                );
                $ret[ResponseConstants::SUCCESSSTRINGS] = array($success_string);
            }

            return $ret;
        }

        return null;
    }

    /**
     * Function to override
     */
    public function getCreateupdate()
    {
        return null;
    }
}
