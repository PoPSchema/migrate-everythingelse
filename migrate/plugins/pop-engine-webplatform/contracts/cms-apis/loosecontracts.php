<?php
namespace PoP\EngineWebPlatform;
use PoP\LooseContracts\AbstractLooseContractSet;

class WebPlatformCMSLooseContracts extends AbstractLooseContractSet
{
	public function getRequiredHooks() {
		return [
			// Actions
			'popcms:enqueueScripts',
			'popcms:printFooterScripts',
			'popcms:printScripts',
			// Filters
			'popcms:scriptSrc',
			'popcms:scriptTag',
		];
	}
}

/**
 * Initialize
 */
new WebPlatformCMSLooseContracts(\PoP\LooseContracts\Facades\LooseContractManagerFacade::getInstance());

