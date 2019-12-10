<?php

abstract class PoP_Module_Processor_HTMLPageCodesBase extends PoP_Module_Processor_HTMLCodesBase
{
    public function getCode(array $module, array &$props)
    {
        $cmspagesapi = \PoP\Pages\FunctionAPIFactory::getInstance();
        return $cmspagesapi->getContent($this->getPageId($module));
    }

    public function getPageId(array $module)
    {
        return null;
    }
}
