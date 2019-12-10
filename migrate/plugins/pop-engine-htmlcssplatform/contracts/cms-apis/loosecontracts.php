<?php
namespace PoP\EngineHTMLCSSPlatform;
use PoP\LooseContracts\AbstractLooseContractSet;

class HTMLCSSPlatformCMSLooseContracts extends AbstractLooseContractSet
{
	public function getRequiredHooks() {
		return [
			// Actions
			'popcms:footer',
			'popcms:head',
			'popcms:printStyles',
			// Filters
			'popcms:styleSrc',
			'popcms:styleTag',
		];
	}
}

/**
 * Initialize
 */
new HTMLCSSPlatformCMSLooseContracts(\PoP\LooseContracts\Facades\LooseContractManagerFacade::getInstance());

