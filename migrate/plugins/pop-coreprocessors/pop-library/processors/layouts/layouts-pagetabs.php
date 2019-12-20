<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Engine\Route\RouteUtils;
use PoP\Posts\Routing\RouteNatures as PostRouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;
use PoP\PostMedia\Misc\MediaHelpers;
use PoP\Posts\Facades\PostTypeAPIFacade;

class PoP_Module_Processor_PageTabsLayouts extends PoP_Module_Processor_PageTabsLayoutsBase
{
    public const MODULE_LAYOUT_PAGETABS_HOME = 'layout-pagetabs-home';
    public const MODULE_LAYOUT_PAGETABS_TAG = 'layout-pagetabs-tag';
    public const MODULE_LAYOUT_PAGETABS_PAGE = 'layout-pagetabs-page';
    public const MODULE_LAYOUT_PAGETABS_ROUTE = 'layout-pagetabs-route';
    public const MODULE_LAYOUT_PAGETABS_SINGLE = 'layout-pagetabs-single';
    public const MODULE_LAYOUT_PAGETABS_AUTHOR = 'layout-pagetabs-author';
    public const MODULE_LAYOUT_PAGETABS_404 = 'layout-pagetabs-404';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_LAYOUT_PAGETABS_HOME],
            [self::class, self::MODULE_LAYOUT_PAGETABS_TAG],
            [self::class, self::MODULE_LAYOUT_PAGETABS_PAGE],
            [self::class, self::MODULE_LAYOUT_PAGETABS_ROUTE],
            [self::class, self::MODULE_LAYOUT_PAGETABS_SINGLE],
            [self::class, self::MODULE_LAYOUT_PAGETABS_AUTHOR],
            [self::class, self::MODULE_LAYOUT_PAGETABS_404],
        );
    }

    protected function getFontawesome(array $module, array &$props)
    {
        $fontawesomes = array(
            self::MODULE_LAYOUT_PAGETABS_HOME => 'fa-home',
            self::MODULE_LAYOUT_PAGETABS_TAG => 'fa-hashtag',
            self::MODULE_LAYOUT_PAGETABS_404 => 'fa-exclamation-circle',
        );
        if ($fontawesome = $fontawesomes[$module[1]]) {
            return $fontawesome;
        }
        return parent::getFontawesome($module, $props);
    }
    protected function getThumb(array $module, array &$props)
    {
        $cmsmediaapi = \PoP\Media\FunctionAPIFactory::getInstance();
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        switch ($module[1]) {
            case self::MODULE_LAYOUT_PAGETABS_AUTHOR:
                $author = $vars['routing-state']['queried-object-id'];
                $avatar = gdGetAvatar($author, GD_AVATAR_SIZE_16);
                return array(
                    'src' => $avatar['src'],
                    'w' => $avatar['size'],
                    'h' => $avatar['size']
                );

            case self::MODULE_LAYOUT_PAGETABS_PAGE:
            case self::MODULE_LAYOUT_PAGETABS_SINGLE:
                $post_id = $vars['routing-state']['queried-object-id'];
                if ($post_thumb_id = MediaHelpers::getThumbId($post_id)) {
                    $thumb = $cmsmediaapi->getMediaSrc($post_thumb_id, 'favicon');
                    return array(
                        'src' => $thumb[0],
                        'w' => $thumb[1],
                        'h' => $thumb[2]
                    );
                }
                break;
        }

        return parent::getThumb($module, $props);
    }
    // protected function getPretitle(array $module, array &$props)
    // {
    //     $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
    //     switch ($module[1]) {
    //         case self::MODULE_LAYOUT_PAGETABS_AUTHOR:
    //         case self::MODULE_LAYOUT_PAGETABS_SINGLE:
    //             $natures = array(
    //                 self::MODULE_LAYOUT_PAGETABS_AUTHOR => UserRouteNatures::USER,
    //                 self::MODULE_LAYOUT_PAGETABS_SINGLE => PostRouteNatures::POST,
    //             );

    //             // For the default page add the thumbnail. For the others, add the pretitle
    //             $page_id = \PoP\ComponentModel\Utils::getRoute();
    //             if ($page_id != \PoP\ComponentModel\Utils::getNatureDefaultPage($natures[$module[1]])) {
    //                 return $cmsengineapi->getTitle($page_id);
    //             }
    //             break;
    //     }

    //     return parent::getPretitle($module, $props);
    // }
    protected function getTitle(array $module, array &$props)
    {
        $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        $cmspagesapi = \PoP\Pages\FunctionAPIFactory::getInstance();
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();

        switch ($module[1]) {
            case self::MODULE_LAYOUT_PAGETABS_AUTHOR:
                $author = $vars['routing-state']['queried-object-id'];
                return $cmsusersapi->getUserDisplayName($author);

            case self::MODULE_LAYOUT_PAGETABS_ROUTE:
                $route = $vars['route'];
                return RouteUtils::getRouteTitle($route);

            case self::MODULE_LAYOUT_PAGETABS_PAGE:
                $page_id = $vars['routing-state']['queried-object-id'];
                return $cmspagesapi->getTitle($page_id);

            case self::MODULE_LAYOUT_PAGETABS_SINGLE:
                $post_id = $vars['routing-state']['queried-object-id'];
                return $postTypeAPI->getTitle($post_id);

            case self::MODULE_LAYOUT_PAGETABS_TAG:
                $tag_id = $vars['routing-state']['queried-object-id'];
                return $taxonomyapi->getTagSymbolName($tag_id);
        }

        $titles = array(
            self::MODULE_LAYOUT_PAGETABS_HOME => TranslationAPIFacade::getInstance()->__('Home', 'poptheme-wassup'),
            self::MODULE_LAYOUT_PAGETABS_404 => TranslationAPIFacade::getInstance()->__('Page not found!', 'poptheme-wassup'),
        );
        if ($title = $titles[$module[1]]) {
            return $title;
        }
        return parent::getTitle($module, $props);
    }
}


