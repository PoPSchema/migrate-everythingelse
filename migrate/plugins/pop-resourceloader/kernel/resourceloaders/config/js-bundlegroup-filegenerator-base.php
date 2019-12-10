<?php
abstract class PoP_ResourceLoader_JSBundleGroupFileBase extends PoP_ResourceLoader_BundleFileFileBase {

	function getDir() {

		return parent::getDir().'/bundlegroups';
	}
	function getUrl() {

		return parent::getUrl().'/bundlegroups';
	}
}
