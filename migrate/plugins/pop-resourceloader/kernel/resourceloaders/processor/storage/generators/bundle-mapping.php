<?php
class PoP_ResourceLoader_BundleMappingStorageFileLocation extends PoP_Engine_ResourceLoaderFileObjectBase {

	function getFilename() {

		return 'bundle-resourceloader-mapping.json';
	}

	protected function acrossThememodes() {

		return true;
	}
}
	
/**
 * Initialize
 */
global $pop_resourceloader_bundlemappingstoragefilelocation;
$pop_resourceloader_bundlemappingstoragefilelocation = new PoP_ResourceLoader_BundleMappingStorageFileLocation();
