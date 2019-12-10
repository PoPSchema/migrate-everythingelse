<?php
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addAction(
	'popcms:init', 
	function() {
		
		if (defined('POP_ADDCOMMENTS_PAGEPLACEHOLDER_SPAMMEDCOMMENTNOTIFICATION')) {
			$cmspagesapi = \PoP\Pages\FunctionAPIFactory::getInstance();
			define('POP_ADDCOMMENTS_URLPLACEHOLDER_SPAMMEDCOMMENTNOTIFICATION', $cmspagesapi->getPageURL(POP_ADDCOMMENTS_PAGEPLACEHOLDER_SPAMMEDCOMMENTNOTIFICATION));
		}
	}
);