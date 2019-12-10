<?php
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;

abstract class GD_DataLoad_FormActionExecuterBase implements \PoP\ComponentModel\ActionExecuterInterface
{
    public function execute(&$data_properties)
    {

        // If the post has been submitted, execute the Gravity Forms shortcode
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            // Before submitting the form, validate the captcha (otherwise, the form is submitted independently of the result of this validation)
            if (PoP_Forms_ConfigurationUtils::captchaEnabled()) {
                $captcha_validation = $this->validateCaptcha($data_properties);
                if (\PoP\ComponentModel\GeneralUtils::isError($captcha_validation)) {
                    return $this->getCaptchaError($captcha_validation);
                }
            }

            return $this->executeForm($data_properties);
        }

        return null;
    }

    protected function validateCaptcha($data_properties)
    {

        // Check if Captcha validation is needed
        if ($data_properties[GD_DATALOAD_QUERYHANDLERPROPERTY_FORM_VALIDATECAPTCHA]) {
            $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
            $captcha = $moduleprocessor_manager->getProcessor([PoP_Module_Processor_CaptchaFormInputs::class, PoP_Module_Processor_CaptchaFormInputs::MODULE_FORMINPUT_CAPTCHA])->getValue([PoP_Module_Processor_CaptchaFormInputs::class, PoP_Module_Processor_CaptchaFormInputs::MODULE_FORMINPUT_CAPTCHA]);

            return GD_Captcha::validate($captcha);
        }

        return true;
    }

    protected function getCaptchaError($captcha_error)
    {
        return array(
            ResponseConstants::ERRORSTRINGS => array($captcha_error->getErrorMessage())
        );
    }

    protected function executeForm(&$data_properties)
    {
        return array(
            ResponseConstants::SUCCESS => true
        );
    }
}
