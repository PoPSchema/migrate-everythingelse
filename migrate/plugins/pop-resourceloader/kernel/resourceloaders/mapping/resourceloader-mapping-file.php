<?php
class PoP_WebPlatform_ResourceLoaderMappingFile extends \PoP\FileStore\File\AbstractFile {

	function getDir() {

		return POP_RESOURCELOADER_BUILD_DIR;
	}

	function getFilename() {

		return 'resourceloader-mapping.json';
	}
}
	
/**
 * Initialize
 */
global $pop_webplatform_resourceloader_mappingfile;
$pop_webplatform_resourceloader_mappingfile = new PoP_WebPlatform_ResourceLoaderMappingFile();
