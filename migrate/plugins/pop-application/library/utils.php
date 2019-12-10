<?php
namespace PoP\Application;

class Utils {

    public static function returnResultOrConvertError($result)
    {
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        $cmsapplicationapi = FunctionAPIFactory::getInstance();
        if ($cmsengineapi->isError($result)) {
            return $cmsapplicationapi->convertFromCMSToPoPError($result);
        }
        return $result;
    }
}