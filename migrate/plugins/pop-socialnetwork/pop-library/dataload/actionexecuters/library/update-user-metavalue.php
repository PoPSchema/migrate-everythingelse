<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_UpdateUserMetaValue
{
    protected function validate(&$errors, $form_data)
    {
        $target_id = $form_data['target_id'];
        if (!$target_id) {
            $errors[] = TranslationAPIFacade::getInstance()->__('This URL is incorrect.', 'pop-coreprocessors');
        }
    }

    /**
     * Function to override
     */
    protected function additionals($target_id, $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('gd_updateusermetavalue', $target_id, $form_data);
    }

    protected function getRequestKey()
    {
        return '';
    }

    protected function getFormData(&$data_properties)
    {
        $form_data = array(
            'target_id' => $_REQUEST[$this->getRequestKey()],
        );
        
        return $form_data;
    }

    protected function update($form_data)
    {
        $target_id = $form_data['target_id'];
        return $target_id;
    }

    public function execute(&$errors, &$data_properties)
    {
        $form_data = $this->getFormData($data_properties);

        $this->validate($errors, $form_data);
        if ($errors) {
            return;
        }

        $target_id = $this->update($form_data);
        $this->additionals($target_id, $form_data);

        return $target_id;
    }
}
