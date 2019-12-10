<?php
namespace PoP\Application\WP;

class FunctionAPI extends \PoP\Application\FunctionAPI_Base
{
    public function convertFromCMSToPoPError($cmsError)
    {
        $error = new \PoP\ComponentModel\Error();
        foreach ($cmsError->get_error_codes() as $code) {
            $error->add($code, $cmsError->get_error_message($code), $cmsError->get_error_data($code));
        }
        return $error;
    }

    public function isAdminPanel()
    {
        return is_admin();
    }

    public function getDocumentTitle()
    {
        return wp_get_document_title();
    }

    public function getSiteName()
    {
        return get_bloginfo('name');
    }

    public function getSiteDescription()
    {
        return get_bloginfo('description');
    }
}

/**
 * Initialize
 */
new FunctionAPI();
