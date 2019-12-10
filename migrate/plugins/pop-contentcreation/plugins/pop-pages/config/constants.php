<?php
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addAction(
	'popcms:init', 
	function() {
		
		if (defined('POP_CONTENTCREATION_PAGEPLACEHOLDER_SPAMMEDPOSTNOTIFICATION')) {
			$cmspagesapi = \PoP\Pages\FunctionAPIFactory::getInstance();
			define('POP_CONTENTCREATION_URLPLACEHOLDER_SPAMMEDPOSTNOTIFICATION', $cmspagesapi->getPageURL(POP_CONTENTCREATION_PAGEPLACEHOLDER_SPAMMEDPOSTNOTIFICATION));
		}
	}
);