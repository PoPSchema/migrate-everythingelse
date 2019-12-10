<?php

class PoP_CoreProcessors_FileReproduction_UserLoggedInStyles extends PoP_Engine_CSSFileReproductionBase
{
    protected $domain;

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    public function getDomain()
    {
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        return $this->domain ?? $cmsengineapi->getSiteURL();
    }

    // public function getRenderer()
    // {
    //     global $popcore_userloggedinstyles_filerenderer;
    //     return $popcore_userloggedinstyles_filerenderer;
    // }

    public function getAssetsPath()
    {
        return dirname(__FILE__).'/assets/css/user-loggedin.css';
    }

    public function getConfiguration()
    {
        $configuration = parent::getConfiguration();

        $configuration['{{$domainId}}'] = \PoP\ComponentModel\Utils::getDomainId($this->getDomain());

        return $configuration;
    }
}
   