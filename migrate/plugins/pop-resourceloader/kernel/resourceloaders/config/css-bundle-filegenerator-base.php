<?php
abstract class PoP_ResourceLoader_CSSBundleFileBase extends PoP_ResourceLoader_BundleFileFileBase {

	function getDir() {

		return parent::getDir().'/bundles';
	}
	function getUrl() {

		return parent::getUrl().'/bundles';
	}
}
