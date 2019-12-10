<?php
use PoP\LooseContracts\AbstractLooseContractSet;

class PoP_AddLocations_LooseContracts extends AbstractLooseContractSet
{
	public function getRequiredNames() {
		return [
			// Options
			'popcomponent:addlocations:option:locationDefaultCountry',
		];
	}
}

/**
 * Initialize
 */
new PoP_AddLocations_LooseContracts(\PoP\LooseContracts\Facades\LooseContractManagerFacade::getInstance());

