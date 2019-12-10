<?php
use PoP\LooseContracts\AbstractLooseContractSet;

class PoP_SocialLogin_LooseContracts extends AbstractLooseContractSet
{
	public function getRequiredHooks() {
		return [
			// Actions
			'popcomponent:sociallogin:usercreated',
		];
	}
}

/**
 * Initialize
 */
new PoP_SocialLogin_LooseContracts(\PoP\LooseContracts\Facades\LooseContractManagerFacade::getInstance());

