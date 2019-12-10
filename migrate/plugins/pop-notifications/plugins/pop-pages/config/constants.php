<?php
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addAction(
	'popcms:init', 
	function() {
		
		if (defined('POP_NOTIFICATIONS_PAGEPLACEHOLDER_USERWELCOME')) {
			$cmspagesapi = \PoP\Pages\FunctionAPIFactory::getInstance();
			define('POP_NOTIFICATIONS_URLPLACEHOLDER_USERWELCOME', $cmspagesapi->getPageURL(POP_NOTIFICATIONS_PAGEPLACEHOLDER_USERWELCOME));
		}
	}
);