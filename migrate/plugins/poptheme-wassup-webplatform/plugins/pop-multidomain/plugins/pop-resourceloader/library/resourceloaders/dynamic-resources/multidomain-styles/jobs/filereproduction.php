<?php

class PoPTheme_Wassup_Multidomain_FileReproduction_Styles extends PoP_Engine_CSSFileReproductionBase
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
    //     global $popthemewassup_multidomainstyles_filerenderer;
    //     return $popthemewassup_multidomainstyles_filerenderer;
    // }

    public function getAssetsPath()
    {
        return dirname(__FILE__).'/assets/css/multidomain.css';
    }

    public function getConfiguration()
    {
        $configuration = parent::getConfiguration();

        $domain = $this->getDomain();
        $domain_bgcolors = PoPTheme_Wassup_MultiDomain_Utils::getMultidomainBgcolors();
        $configuration['{{$domainId}}'] = \PoP\ComponentModel\Utils::getDomainId($domain);
        $configuration['{{$backgroundColor}}'] = $domain_bgcolors[$domain];

        return $configuration;
    }
}
    