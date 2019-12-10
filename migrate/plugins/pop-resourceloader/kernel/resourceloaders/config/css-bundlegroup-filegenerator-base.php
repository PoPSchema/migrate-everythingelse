<?php
abstract class PoP_ResourceLoader_CSSBundleGroupFileBase extends PoP_ResourceLoader_BundleFileFileBase {

	function getDir() {

		return parent::getDir().'/bundlegroups';
	}
	function getUrl() {

		return parent::getUrl().'/bundlegroups';
	}
}
