<?php

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;
use PoP\CustomPosts\Types\Status;

class GD_CreateUpdate_Highlight extends GD_CreateUpdate_PostBase
{
    protected function supportsTitle()
    {
        return false;
    }

    protected function getEditorInput()
    {
        return [PoP_Module_Processor_TextareaFormInputs::class, PoP_Module_Processor_TextareaFormInputs::MODULE_FORMINPUT_TEXTAREAEDITOR];
    }

    protected function getFormData(&$data_properties)
    {
        $form_data = parent::getFormData($data_properties);

        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $form_data['highlightedpost'] = $moduleprocessor_manager->getProcessor([PoP_AddHighlights_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_AddHighlights_Module_Processor_PostTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_HIGHLIGHTEDPOST])->getValue([PoP_AddHighlights_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_AddHighlights_Module_Processor_PostTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_HIGHLIGHTEDPOST]);

        // Highlights have no title input by the user. Instead, produce the title from the referenced post
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        $referenced = $postTypeAPI->getPost($form_data['highlightedpost']);
        $form_data['title'] = $postTypeAPI->getTitle($referenced);

        return $form_data;
    }

    // Update Post Validation
    protected function validatecontent(&$errors, $form_data)
    {

        // Validate that the referenced post has been added (protection against hacking)
        // For highlights, we only add 1 reference, and not more.
        if (!$form_data['highlightedpost']) {
            $errors[] = TranslationAPIFacade::getInstance()->__('No post has been highlighted', 'poptheme-wassup');
        } else {
            // Highlights have no title input by the user. Instead, produce the title from the referenced post
            $postTypeAPI = PostTypeAPIFacade::getInstance();
            $referenced = $postTypeAPI->getPost($form_data['highlightedpost']);
            if (!$referenced) {
                $errors[] = TranslationAPIFacade::getInstance()->__('The highlighted post does not exist', 'poptheme-wassup');
            } else {
                // If the referenced post has not been published yet, then error
                if ($postTypeAPI->getStatus($referenced) != Status::PUBLISHED) {
                    $errors[] = TranslationAPIFacade::getInstance()->__('The highlighted post is not published yet', 'poptheme-wassup');
                }
            }
        }

        // If cheating then that's it, no need to validate anymore
        if (!$errors) {
            parent::validatecontent($errors, $form_data);
        }
    }

    protected function getPostType($form_data)
    {
        return POP_ADDHIGHLIGHTS_POSTTYPE_HIGHLIGHT;
    }

    protected function moderate()
    {
        return false;
    }

    protected function getSuccessTitle($referenced = null)
    {
        if ($referenced) {
            $postTypeAPI = PostTypeAPIFacade::getInstance();
            return sprintf(
                TranslationAPIFacade::getInstance()->__('Highlight from “%s”', 'poptheme-wassup'),
                $postTypeAPI->getTitle($referenced)
            );
        }

        return TranslationAPIFacade::getInstance()->__('Highlight', 'poptheme-wassup');
    }

    protected function createadditionals($post_id, $form_data)
    {
        parent::createadditionals($post_id, $form_data);

        \PoP\CustomPostMeta\Utils::addCustomPostMeta($post_id, GD_METAKEY_POST_HIGHLIGHTEDPOST, $form_data['highlightedpost'], true);

        // Allow to create a Notification
        HooksAPIFacade::getInstance()->doAction('GD_CreateUpdate_Highlight:createadditionals', $post_id, $form_data);
    }

    protected function updateadditionals($post_id, $form_data, $log)
    {
        parent::updateadditionals($post_id, $form_data, $log);

        // Allow to create a Notification
        HooksAPIFacade::getInstance()->doAction('GD_CreateUpdate_Highlight:updateadditionals', $post_id, $form_data, $log);
    }
}
