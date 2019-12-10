<?php
namespace PoP\EditPosts;
use PoP\LooseContracts\AbstractLooseContractSet;

class CMSLooseContracts extends AbstractLooseContractSet
{
	public function getRequiredHooks() {
		return [
			// Actions
			'popcms:publishToDraft',
			'popcms:savePost',
			'popcms:pendingToPublish',
			'popcms:transitionPostStatus',
			// Filters
			'popcms:editPostLink',
		];
	}
}

/**
 * Initialize
 */
new CMSLooseContracts(\PoP\LooseContracts\Facades\LooseContractManagerFacade::getInstance());

