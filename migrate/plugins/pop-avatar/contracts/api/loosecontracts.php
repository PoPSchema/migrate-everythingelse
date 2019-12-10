<?php
use PoP\LooseContracts\AbstractLooseContractSet;

class PoP_Avatar_LooseContracts extends AbstractLooseContractSet
{
	public function getRequiredHooks() {
		return [
			// Filters
			'popcomponent:avatar:avatarexists',
			// Actions
			'popcomponent:avatar:avataruploaded',
		];
	}
}

/**
 * Initialize
 */
new PoP_Avatar_LooseContracts(\PoP\LooseContracts\Facades\LooseContractManagerFacade::getInstance());

