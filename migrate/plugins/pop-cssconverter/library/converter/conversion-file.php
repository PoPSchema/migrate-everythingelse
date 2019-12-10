<?php
use PoP\Hooks\Facades\HooksAPIFacade;
class PoP_CSSConverter_ConversionFile extends \PoP\FileStore\File\AbstractFile
{
    public function getDir()
    {
        return POP_CSSCONVERTER_BUILD_DIR;
    }

    public function getFilename()
    {
        return 'css-to-style-mapping.json';
    }
}
    
/**
 * Initialize
 */
global $pop_cssconverter_conversionfile;
$pop_cssconverter_conversionfile = new PoP_CSSConverter_ConversionFile();
