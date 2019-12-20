<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\ModuleProcessors\DataloadingConstants;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\Posts\Facades\PostTypeAPIFacade;

abstract class GD_DataLoad_ActionExecuter_CreateUpdate_PostBase implements \PoP\ComponentModel\ActionExecuterInterface
{
    public function getSuccessString($post_id, $status)
    {
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        if ($status == POP_POSTSTATUS_PUBLISHED) {
            $success_string = sprintf(
                TranslationAPIFacade::getInstance()->__('<a href="%s" %s>Click here to view it</a>.', 'pop-application'),
                $postTypeAPI->getPermalink($post_id),
                getReloadurlLinkattrs()
            );
        } elseif ($status == POP_POSTSTATUS_DRAFT) {
            $success_string = TranslationAPIFacade::getInstance()->__('The status is still “Draft”, so it won\'t be online.', 'pop-application');
        } elseif ($status == POP_POSTSTATUS_PENDING) {
            $success_string = TranslationAPIFacade::getInstance()->__('Now waiting for approval from the admins.', 'pop-application');
        }

        return HooksAPIFacade::getInstance()->applyFilters('gd-createupdate-post:execute:successstring', $success_string, $post_id, $status);
    }

    public function execute(&$data_properties)
    {

        // If the post has been submitted, execute the Gravity Forms shortcode
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $createupdate = $this->getCreateupdate();
            $errors = array();
            $post_id = $createupdate->createOrUpdate($errors, $data_properties);

            if ($errors) {
                // Bring no results
                $data_properties[DataloadingConstants::SKIPDATALOAD] = true;
                return array(
                    ResponseConstants::ERRORSTRINGS => $errors
                );
            }

            $this->modifyDataProperties($data_properties, $post_id);

            // Success String: check if the post status is 'publish' or 'pending', and so print the corresponding URL or Preview URL
            $postTypeAPI = PostTypeAPIFacade::getInstance();
            $status = $postTypeAPI->getStatus($post_id);
            $success_string = $this->getSuccessString($post_id, $status);

            // Save the result for some module to incorporate it into the query args
            $gd_dataload_actionexecution_manager = \PoP\ComponentModel\ActionExecutionManagerFactory::getInstance();
            $gd_dataload_actionexecution_manager->setResult(self::class, $post_id);

            // No errors => success
            return array(
                ResponseConstants::SUCCESS => true,
                ResponseConstants::SUCCESSSTRINGS => array($success_string)
            );
        }

        return null;
    }

    public function modifyDataProperties(&$data_properties, $post_id)
    {

        // Modify the block-data-settings, saying to select the id of the newly created post
        $data_properties[DataloadingConstants::QUERYARGS]['include'] = array($post_id);
        $data_properties[DataloadingConstants::QUERYARGS]['post-status'] = [
            POP_POSTSTATUS_PUBLISHED,
            POP_POSTSTATUS_PENDING,
            POP_POSTSTATUS_DRAFT,
        ];
    }

    /**
     * Function to override
     */
    public function getCreateupdate()
    {
        return null;
    }
}
