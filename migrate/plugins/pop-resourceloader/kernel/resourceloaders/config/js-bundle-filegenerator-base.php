<?php
abstract class PoP_ResourceLoader_JSBundleFileBase extends PoP_ResourceLoader_BundleFileFileBase {

	public function getDir(): string {

		return parent::getDir().'/bundles';
	}
	public function getUrl(): string {

		return parent::getUrl().'/bundles';
	}
}
