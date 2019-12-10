<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

define('POP_POSTSPROCESSORS_POP_POSTS_MIN_VERSION', 0.1);

class PoP_PostsProcessors_Validation
{
    public function validate()
    {
        $success = true;
        if (!defined('POP_POSTS_VERSION')) {
            HooksAPIFacade::getInstance()->addAction('admin_notices', array($this,'installWarning'));
            HooksAPIFacade::getInstance()->addAction('network_admin_notices', array($this,'installWarning'));
            $success = false;
        } elseif (!defined('POP_POSTS_INITIALIZED')) {
            HooksAPIFacade::getInstance()->addAction('admin_notices', array($this, 'initializeWarning'));
            HooksAPIFacade::getInstance()->addAction('network_admin_notices', array($this, 'initializeWarning'));
            $success = false;
        } elseif (POP_POSTSPROCESSORS_POP_POSTS_MIN_VERSION > POP_POSTS_VERSION) {
            HooksAPIFacade::getInstance()->addAction('admin_notices', array($this,'versionWarning'));
            HooksAPIFacade::getInstance()->addAction('network_admin_notices', array($this,'versionWarning'));
        }

        return $success;
    }
    public function initializeWarning()
    {
        $this->dependencyInitializationWarning(
            TranslationAPIFacade::getInstance()->__('PoP Posts Processors', 'pop-posts-processors'),
            TranslationAPIFacade::getInstance()->__('PoP Posts', 'pop-posts-processors')
        );
    }
    public function installWarning()
    {
        $this->dependencyInstallationWarning(
            TranslationAPIFacade::getInstance()->__('PoP Posts Processors', 'pop-posts-processors'),
            TranslationAPIFacade::getInstance()->__('PoP Posts', 'pop-posts-processors'),
            'https://github.com/leoloso/PoP'
        );
    }
    public function versionWarning()
    {
        $this->dependencyVersionWarning(
            TranslationAPIFacade::getInstance()->__('PoP Posts Processors', 'pop-posts-processors'),
            TranslationAPIFacade::getInstance()->__('PoP Posts', 'pop-posts-processors'),
            'https://github.com/leoloso/PoP',
            POP_POSTSPROCESSORS_POP_POSTS_MIN_VERSION
        );
    }
    protected function dependencyInstallationWarning($plugin, $dependency, $dependency_url)
    {
        $this->adminNotice(
            sprintf(
                TranslationAPIFacade::getInstance()->__('Error: %s', 'pop-webplatformposts'),
                sprintf(
                    TranslationAPIFacade::getInstance()->__('<strong>%s</strong> is not installed/activated. Without it, <strong>%s</strong> will not work. Please install this plugin from your plugin installer or download it <a href="%s" target="_blank">from here</a>.', 'pop-webplatformposts'),
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
                TranslationAPIFacade::getInstance()->__('Error: %s', 'pop-webplatformposts'),
                sprintf(
                    TranslationAPIFacade::getInstance()->__('<strong>%s</strong> is not initialized properly. As a consequence, <strong>%s</strong> has not been loaded.', 'pop-webplatformposts'),
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
                TranslationAPIFacade::getInstance()->__('Error: %s', 'pop-webplatformposts'),
                sprintf(
                    TranslationAPIFacade::getInstance()->__('<strong>%s</strong> requires version %s or bigger of <strong>%s</strong>. Please update this plugin from your plugin installer or download it <a href="%s" target="_blank">from here</a>.', 'pop-webplatformposts'),
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
        <?php _e('Only admins see this message.', 'pop-webplatformposts'); ?>
                </em>
            </p>
        </div>
        <?php
    }
}
