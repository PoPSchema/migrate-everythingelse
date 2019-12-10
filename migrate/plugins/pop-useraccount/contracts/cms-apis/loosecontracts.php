<?php
namespace PoP\UserAccount;
use PoP\LooseContracts\AbstractLooseContractSet;

class CMSLooseContracts extends AbstractLooseContractSet
{
	public function getRequiredHooks() {
		return [
			// Filters
			'popcms:loginUrl',
			'popcms:lostPasswordUrl',
			'popcms:logoutUrl',
			'popcms:authCookieExpiration',
			'popcms:retrievePasswordTitle',
			'popcms:retrievePasswordMessage',
		];
	}

	public function getRequiredNames() {
		return [
			// Capabilities
			'popcms:capability:editPosts',
			'popcms:capability:deletePages',
		];
	}
}

/**
 * Initialize
 */
new CMSLooseContracts(\PoP\LooseContracts\Facades\LooseContractManagerFacade::getInstance());

