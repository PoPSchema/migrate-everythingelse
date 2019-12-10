<?php
use PoP\LooseContracts\AbstractLooseContractSet;

class PoP_UserPlatform_LooseContracts extends AbstractLooseContractSet
{
	public function getRequiredNames() {
		return [
			// DB Columns
			'popcomponent:userplatform:dbcolumn:orderby:users:lastediteddate',
		];
	}
}

/**
 * Initialize
 */
new PoP_UserPlatform_LooseContracts(\PoP\LooseContracts\Facades\LooseContractManagerFacade::getInstance());

