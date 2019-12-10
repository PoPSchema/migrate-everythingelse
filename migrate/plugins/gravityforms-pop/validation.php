<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

define('GFPOP_POP_CMSWP_MIN_VERSION', 0.1);
define('GFPOP_POP_FORMS_MIN_VERSION', 0.1);
define('GFPOP_GF_MIN_VERSION', 0.1);

class GFPoP_Validation
{
    public function validate()
    {
        $success = true;
        if (!defined('POP_ENGINEWP_VERSION')) {
            HooksAPIFacade::getInstance()->addAction('admin_notices', array($this,'installWarning'));
            HooksAPIFacade::getInstance()->addAction('network_admin_notices', array($this,'installWarning'));
            $success = false;
        } elseif (!defined('POP_ENGINEWP_INITIALIZED')) {
            HooksAPIFacade::getInstance()->addAction('admin_notices', array($this, 'initializeWarning'));
            HooksAPIFacade::getInstance()->addAction('network_admin_notices', array($this, 'initializeWarning'));
            $success = false;
        } elseif (GFPOP_POP_CMSWP_MIN_VERSION > POP_ENGINEWP_VERSION) {
            HooksAPIFacade::getInstance()->addAction('admin_notices', array($this,'versionWarning'));
            HooksAPIFacade::getInstance()->addAction('network_admin_notices', array($this,'versionWarning'));
        }

        if (!defined('POP_FORMS_VERSION')) {
            HooksAPIFacade::getInstance()->addAction('admin_notices', array($this, 'install_warning_2'));
            HooksAPIFacade::getInstance()->addAction('network_admin_notices', array($this, 'install_warning_2'));
            $success = false;
        } elseif (!defined('POP_FORMS_INITIALIZED')) {
            HooksAPIFacade::getInstance()->addAction('admin_notices', array($this, 'initialize_warning_2'));
            HooksAPIFacade::getInstance()->addAction('network_admin_notices', array($this, 'initialize_warning_2'));
            $success = false;
        } elseif (GFPOP_POP_FORMS_MIN_VERSION > POP_FORMS_VERSION) {
            HooksAPIFacade::getInstance()->addAction('admin_notices', array($this, 'version_warning_2'));
            HooksAPIFacade::getInstance()->addAction('network_admin_notices', array($this, 'version_warning_2'));
        }

        // Validate plug-in
        if (!class_exists('GFForms')) {
            HooksAPIFacade::getInstance()->addAction('admin_notices', array($this,'pluginWarning'));
            HooksAPIFacade::getInstance()->addAction('network_admin_notices', array($this,'pluginWarning'));
            $success = false;
        } elseif (GFPOP_GF_MIN_VERSION > GFForms::$version) {
            HooksAPIFacade::getInstance()->addAction('admin_notices', array($this,'pluginversion_warning'));
            HooksAPIFacade::getInstance()->addAction('network_admin_notices', array($this,'pluginversion_warning'));
        }

        return $success;
    }
    public function initializeWarning()
    {
        $this->dependencyInitializationWarning(
            TranslationAPIFacade::getInstance()->__('Gravity Forms for PoP', 'gravityforms-pop'),
            TranslationAPIFacade::getInstance()->__('PoP Engine for WordPress', 'gravityforms-pop')
        );
    }
    public function installWarning()
    {
        $this->dependencyInstallationWarning(
            TranslationAPIFacade::getInstance()->__('Gravity Forms for PoP', 'gravityforms-pop'),
            TranslationAPIFacade::getInstance()->__('PoP Engine for WordPress', 'gravityforms-pop'),
            'https://github.com/leoloso/PoP'
        );
    }
    public function versionWarning()
    {
        $this->dependencyVersionWarning(
            TranslationAPIFacade::getInstance()->__('Gravity Forms for PoP', 'gravityforms-pop'),
            TranslationAPIFacade::getInstance()->__('PoP Engine for WordPress', 'gravityforms-pop'),
            'https://github.com/leoloso/PoP',
            GFPOP_POP_CMSWP_MIN_VERSION
        );
    }
    public function initialize_warning_2()
    {
        $this->dependencyInitializationWarning(
            TranslationAPIFacade::getInstance()->__('Gravity Forms for PoP', 'gravityforms-pop'),
            TranslationAPIFacade::getInstance()->__('PoP Forms', 'gravityforms-pop')
        );
    }
    public function install_warning_2()
    {
        $this->dependencyInstallationWarning(
            TranslationAPIFacade::getInstance()->__('Gravity Forms for PoP', 'gravityforms-pop'),
            TranslationAPIFacade::getInstance()->__('PoP Forms', 'gravityforms-pop'),
            'https://github.com/leoloso/PoP'
        );
    }
    public function version_warning_2()
    {
        $this->dependencyVersionWarning(
            TranslationAPIFacade::getInstance()->__('Gravity Forms for PoP', 'gravityforms-pop'),
            TranslationAPIFacade::getInstance()->__('PoP Forms', 'gravityforms-pop'),
            'https://github.com/leoloso/PoP',
            GFPOP_POP_FORMS_MIN_VERSION
        );
    }
    public function pluginWarning()
    {
        $this->dependencyInstallationWarning(
            TranslationAPIFacade::getInstance()->__('Gravity Forms for PoP', 'gravityforms-pop'),
            TranslationAPIFacade::getInstance()->__('Gravity Forms', 'gravityforms-pop'),
            'https://www.gravityforms.com/'
        );
    }
    public function pluginversion_warning()
    {
        $this->dependencyVersionWarning(
            TranslationAPIFacade::getInstance()->__('Gravity Forms for PoP', 'gravityforms-pop'),
            TranslationAPIFacade::getInstance()->__('Gravity Forms', 'gravityforms-pop'),
            'https://www.gravityforms.com/',
            GFPOP_GF_MIN_VERSION
        );
    }
    protected function dependencyInstallationWarning($plugin, $dependency, $dependency_url)
    {
        $this->adminNotice(
            sprintf(
                TranslationAPIFacade::getInstance()->__('Error: %s', 'pop-engine-webplatform'),
                sprintf(
                    TranslationAPIFacade::getInstance()->__('<strong>%s</strong> is not installed/activated. Without it, <strong>%s</strong> will not work. Please install this plugin from your plugin installer or download it <a href="%s" target="_blank">from here</a>.', 'pop-engine-webplatform'),
                    $dependency,
                    $plugin,
                    $dependency_url
                )
            )
        );
    }
    protected function dependencyInitializationWarning($plugin, $dependency)
    {
        $this->adminNotice(
            sprintf(
                TranslationAPIFacade::getInstance()->__('Error: %s', 'pop-engine-webplatform'),
                sprintf(
                    TranslationAPIFacade::getInstance()->__('<strong>%s</strong> is not initialized properly. As a consequence, <strong>%s</strong> has not been loaded.', 'pop-engine-webplatform'),
                    $dependency,
                    $plugin
                )
            )
        );
    }
    protected function dependencyVersionWarning($plugin, $dependency, $dependency_url, $dependency_min_version)
    {
        $this->adminNotice(
            sprintf(
                TranslationAPIFacade::getInstance()->__('Error: %s', 'pop-engine-webplatform'),
                sprintf(
                    TranslationAPIFacade::getInstance()->__('<strong>%s</strong> requires version %s or bigger of <strong>%s</strong>. Please update this plugin from your plugin installer or download it <a href="%s" target="_blank">from here</a>.', 'pop-engine-webplatform'),
                    $plugin,
                    $dependency_min_version,
                    $dependency,
                    $dependency_url
                )
            )
        );
    }
    protected function adminNotice($message)
    {
        ?>
        <div class="error">
            <p>
        <?php echo $message ?><br/>
                <em>
        <?php _e('Only admins see this message.', 'pop-engine-webplatform'); ?>
                </em>
            </p>
        </div>
        <?php
    }
}
