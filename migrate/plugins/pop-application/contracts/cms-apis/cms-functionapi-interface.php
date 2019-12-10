<?php
namespace PoP\Application;

interface FunctionAPI
{
    public function convertFromCMSToPoPError($cmsError);
    public function isAdminPanel();
    public function getDocumentTitle();
    public function getSiteName();
    public function getSiteDescription();
}
