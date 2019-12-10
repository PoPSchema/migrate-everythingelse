<?php
namespace PoP\EditUsers;
use PoP\LooseContracts\AbstractLooseContractSet;

class CMSLooseContracts extends AbstractLooseContractSet
{
	public function getRequiredHooks() {
		return [
			// Actions
			'popcms:deleteUser',
			'popcms:userRegister',
		];
	}
}

/**
 * Initialize
 */
new CMSLooseContracts(\PoP\LooseContracts\Facades\LooseContractManagerFacade::getInstance());

