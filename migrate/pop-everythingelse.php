<?php
namespace PoPSchema\EverythingElse;
use PoP\Hooks\Facades\HooksAPIFacade;

class Plugins
{
    public function __construct()
    {
        // Priority: new section, after PoP CMS Model and PoP Meta
        HooksAPIFacade::getInstance()->addAction('plugins_loaded', array($this, 'init'), 888100);
        HooksAPIFacade::getInstance()->addAction('plugins_loaded', array($this, 'initMigratePackages'), 88820);
    }
    public function init()
    {
        $plugins = [
            'advanced-custom-fields-pop',
            'amazon-s3-and-cloudfront-pop',
            'amazon-s3-and-cloudfront-pop-webplatform',
            'aryo-activity-log-pop',
            'aryo-activity-log-pop-custom',
            'co-authors-plus-pop',
            'getpop-demo-pages',
            'getpop-demo-pages-processors',
            'google-analytics-dashboard-for-wp-pop',
            'google-sitemap-generator-pop',
            'gravityforms-pop-genericforms',
            'gravityforms-pop-processors',
            'gravityforms-pop-webplatform',
            'photoswipe-pop',
            'pop-addcoauthors',
            'pop-addcoauthors-processors',
            'pop-addcomments',
            'pop-addcomments-processors',
            'pop-addcomments-tinymce',
            'pop-addcomments-tinymce-processors',
            'pop-addcomments-webplatform',
            'pop-addhighlights',
            'pop-addhighlights-processors',
            'pop-addhighlights-webplatform',
            'pop-addhighlights-wp',
            'pop-addlocations',
            'pop-addlocations-processors',
            'pop-addlocations-webplatform',
            // 'pop-addpostlinks',
            // 'pop-addpostlinks-processors',
            // 'pop-addpostlinks-webplatform',
            'pop-addrelatedposts',
            'pop-addrelatedposts-processors',
            'pop-application',
            'pop-application-processors',
            'pop-application-taxonomies',
            'pop-application-taxonomies-wp',
            'pop-application-webplatform',
            'pop-application-wp',
            'pop-application-wp-webplatform',
            'pop-automatedemails',
            'pop-avatar',
            'pop-avatar-aws',
            'pop-avatar-foundation',
            'pop-avatar-processors',
            'pop-avatar-webplatform',
            'pop-aws',
            'pop-basecollection-processors',
            'pop-basecollection-webplatform',
            'pop-blog',
            'pop-blog-processors',
            'pop-blog-webplatform',
            'pop-bootstrap-processors',
            'pop-bootstrap-webplatform',
            'pop-bootstrapcollection-processors',
            'pop-bootstrapcollection-webplatform',
            'pop-captcha',
            'pop-captcha-processors',
            'pop-captcha-webplatform',
            'pop-categoryposts',
            'pop-categoryposts-processors',
            'pop-categoryposts-webplatform',
            'pop-categorypostscreation',
            'pop-categorypostscreation-processors',
            'pop-categorypostscreation-webplatform',
            'pop-cdn',
            'pop-cdn-foundation',
            'pop-cdn-foundation-wp',
            'pop-cdn-wp',
            'pop-coauthors',
            'pop-coauthors-processors',
            'pop-commonautomatedemails',
            'pop-commonautomatedemails-processors',
            'pop-commonautomatedemails-webplatform',
            'pop-commonpages',
            'pop-commonpages-processors',
            'pop-commonpages-webplatform',
            'pop-commonuserroles',
            'pop-commonuserroles-processors',
            'pop-commonuserroles-webplatform',
            'pop-contactus',
            'pop-contactus-processors',
            'pop-contactus-webplatform',
            'pop-contentcreation',
            'pop-contentcreation-processors',
            'pop-contentcreation-webplatform',
            // 'pop-contentpostlinks',
            // 'pop-contentpostlinks-processors',
            // 'pop-contentpostlinks-webplatform',
            // 'pop-contentpostlinkscreation',
            // 'pop-contentpostlinkscreation-processors',
            // 'pop-contentpostlinkscreation-webplatform',
            'pop-coreprocessors',
            'pop-cssconverter',
            'pop-cssconverter-webplatform',
            'pop-domain',
            'pop-editposts',
            'pop-editposts-wp',
            'pop-editusers',
            'pop-editusers-wp',
            'pop-emailsender',
            'pop-emailsender-aws',
            'pop-emailsender-wp',
            'pop-engine-htmlcssplatform',
            'pop-engine-htmlcssplatform-wp',
            'pop-engine-processors',
            'pop-engine-webplatform',
            'pop-engine-webplatform-aws',
            'pop-engine-webplatform-optimizations',
            'pop-engine-webplatform-wp',
            'pop-events',
            // 'pop-eventlinks',
            // 'pop-eventlinks-processors',
            // 'pop-eventlinks-webplatform',
            // 'pop-eventlinkscreation',
            // 'pop-eventlinkscreation-processors',
            // 'pop-eventlinkscreation-webplatform',
            'pop-events-processors',
            'pop-events-webplatform',
            'pop-eventscreation',
            'pop-eventscreation-processors',
            'pop-eventscreation-webplatform',
            'pop-examplemodules',
            'pop-forms',
            'pop-forms-processors',
            'pop-forms-webplatform',
            'pop-googleanalytics',
            'pop-hashtagsandmentions-processors',
            'pop-hashtagsandmentions-webplatform',
            'pop-locationpostcategorylayouts-processors',
            // 'pop-locationpostlinks',
            // 'pop-locationpostlinks-processors',
            // 'pop-locationpostlinkscreation',
            // 'pop-locationpostlinkscreation-processors',
            // 'pop-locationpostlinkscreation-webplatform',
            'pop-locationposts',
            'pop-locationposts-processors',
            'pop-locationposts-webplatform',
            'pop-locationposts-wp',
            'pop-locationpostscreation',
            'pop-locationpostscreation-processors',
            'pop-locationpostscreation-webplatform',
            'pop-locations-processors',
            'pop-locations-webplatform',
            'pop-mailer-aws',
            'pop-mastercollection-processors',
            'pop-mastercollection-webplatform',
            'pop-mediahostthumbs',
            'pop-multidomain',
            'pop-multidomain-processors',
            'pop-multidomain-sparesourceloader',
            'pop-multilingual',
            'pop-multilingual-processors',
            'pop-multilingual-webplatform',
            'pop-newsletter',
            'pop-newsletter-processors',
            'pop-newsletter-webplatform',
            'pop-nosearchcategoryposts',
            'pop-nosearchcategoryposts-processors',
            'pop-nosearchcategoryposts-webplatform',
            'pop-nosearchcategorypostscreation',
            'pop-nosearchcategorypostscreation-processors',
            'pop-nosearchcategorypostscreation-webplatform',
            'pop-notifications',
            'pop-notifications-processors',
            'pop-notifications-webplatform',
            'pop-postcategorylayouts-processors',
            'pop-postscreation',
            'pop-postscreation-processors',
            'pop-postscreation-webplatform',
            'pop-prettyprint',
            'pop-previewcontent',
            'pop-previewcontent-webplatform',
            'pop-relatedposts',
            'pop-relatedposts-processors',
            'pop-relatedposts-webplatform',
            'pop-resourceloader',
            'pop-serviceworkers',
            'pop-share',
            'pop-share-processors',
            'pop-share-webplatform',
            'pop-sociallogin',
            'pop-sociallogin-processors',
            'pop-sociallogin-webplatform',
            'pop-socialmediaproviders-processors',
            'pop-socialnetwork',
            'pop-socialnetwork-processors',
            'pop-socialnetwork-webplatform',
            'pop-spa',
            'pop-spa-processors',
            'pop-spa-webplatform',
            'pop-sparesourceloader',
            'pop-ssr',
            'pop-system',
            'pop-system-persistentdefinitions',
            'pop-system-wp',
            'pop-theme',
            'pop-theme-webplatform',
            'pop-theme-wp',
            'pop-themehelpers',
            'pop-tinymce',
            'pop-tinymce-webplatform',
            'pop-trendingtags',
            'pop-trendingtags-processors',
            'pop-trendingtags-webplatform',
            'pop-trendingtags-wp',
            'pop-typeahead-processors',
            'pop-typeahead-webplatform',
            'pop-useraccount',
            'pop-useraccount-wp',
            'pop-useravatar',
            'pop-useravatar-aws',
            'pop-useravatar-processors',
            'pop-useravatar-webplatform',
            'pop-usercommunities',
            'pop-usercommunities-processors',
            'pop-usercommunities-webplatform',
            'pop-userlogin',
            'pop-userlogin-processors',
            'pop-userlogin-webplatform',
            'pop-userlogin-wp',
            'pop-userplatform',
            'pop-userplatform-processors',
            'pop-userplatform-webplatform',
            'pop-userplatform-wp',
            'pop-userroles',
            'pop-userroles-wp',
            'pop-userstance',
            'pop-userstance-processors',
            'pop-userstance-processors-wp',
            'pop-userstance-webplatform',
            'pop-userstance-wp',
            'pop-userstate',
            'pop-viewcomponentheaders-processors',
            'pop-viewcomponentheaders-webplatform',
            'pop-volunteering',
            'pop-volunteering-processors',
            'pop-volunteering-webplatform',
            'poptheme-wassup',
            'poptheme-wassup-getpop-demo',
            'poptheme-wassup-webplatform',
            'public-post-preview-pop',
            'qtranslate-x-pop',
            'user-avatar-popfork',
            'user-avatar-popfork-pop',
            'wordpress-social-login-pop',
            'wordpress-social-login-pop-webplatform',
            'wp-super-cache-pop',
        ];
        foreach ($plugins as $plugin) {
            require_once ('plugins/'.$plugin.'/'.$plugin.'.php');
        }
    }
    public function initMigratePackages()
    {
        // Migrate packages that I wanted to remove from Packagist
        $migratePackages = [
            'migrate-engine' => 'pop-engine.php',
            'migrate-engine-wp' => 'pop-engine-wp.php',
            'migrate-commentmeta' => 'pop-commentmeta.php',
            'migrate-commentmeta-wp' => 'pop-commentmeta-wp.php',
        ];
        foreach ($migratePackages as $migratePackage => $file) {
            require_once ("migrate-packages/${migratePackage}/migrate/${file}.php");
        }

        // Initialize dependencies too
        require_once (dirname(__DIR__, 2) . '/migrate-meta/migrate/pop-meta.php');
        require_once (dirname(__DIR__, 2) . '/migrate-custompostmeta/migrate/pop-custompostmeta.php');
        require_once (dirname(__DIR__, 2) . '/migrate-custompostmeta-wp/migrate/pop-custompostmeta-wp.php');
        require_once (dirname(__DIR__, 2) . '/migrate-usermeta/migrate/pop-usermeta.php');
        require_once (dirname(__DIR__, 2) . '/migrate-usermeta-wp/migrate/pop-usermeta-wp.php');
        require_once (dirname(__DIR__, 2) . '/migrate-taxonomymeta/migrate/pop-taxonomymeta.php');
        require_once (dirname(__DIR__, 2) . '/migrate-taxonomymeta-wp/migrate/pop-taxonomymeta-wp.php');
        require_once (dirname(__DIR__, 2) . '/migrate-events-wp-em/migrate/pop-events-wp-em.php');
        require_once (dirname(__DIR__, 2) . '/migrate-locations-wp-em/migrate/pop-locations-wp-em.php');
        require_once (dirname(__DIR__, 2) . '/migrate-locations/migrate/pop-locations.php');
        require_once (dirname(__DIR__, 2) . '/migrate-posts/migrate/pop-posts.php');
    }
}

/**
 * Initialization
 */
new Plugins();
