<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_CMSModel_Utils {

	public static function getLayoutsModule()
	{
		return HooksAPIFacade::getInstance()->applyFilters(
            'PoP_Module_Processor_MultipleContentInners:modules:layouts',
            null
        );
	}

	public static function getFieldsModule()
	{
		return HooksAPIFacade::getInstance()->applyFilters(
            'PoP_Module_Processor_MultipleContentInners:modules:fields',
            null
        );
	}
}