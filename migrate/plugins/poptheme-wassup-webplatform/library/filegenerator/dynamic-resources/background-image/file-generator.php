<?php
class PoPThemeWassup_BackgroundImage_File extends \PoP\FileStore\File\AbstractAccessibleRenderableFile
{
    public function getDir()
    {
        return POPTHEME_WASSUPWEBPLATFORM_THEMECUSTOMIZATION_ASSETDESTINATION_DIR;
    }
    public function getUrl()
    {
        return POPTHEME_WASSUPWEBPLATFORM_THEMECUSTOMIZATION_ASSETDESTINATION_URL;
    }

    public function getFilename()
    {
        return 'background-image.css';
    }

    // public function getRenderer()
    // {
    //     global $popthemewassup_backgroundimage_filerenderer;
    //     return $popthemewassup_backgroundimage_filerenderer;
    // }
    protected function getFragmentObjects(): array
    {
        return [
            new PoPThemeWassup_FileReproduction_BackgroundImage(),
        ];
    }
}
    
/**
 * Initialize
 */
global $popthemewassup_backgroundimage_file;
$popthemewassup_backgroundimage_file = new PoPThemeWassup_BackgroundImage_File();
