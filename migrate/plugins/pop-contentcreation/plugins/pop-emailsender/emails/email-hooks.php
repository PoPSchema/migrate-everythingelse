<?php
define('POP_EMAIL_CREATEDCONTENT', 'created-content');

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

class PoP_ContentCreation_EmailSender_Hooks
{
    public function __construct()
    {

        //----------------------------------------------------------------------
        // Notifications to the admin
        //----------------------------------------------------------------------
        HooksAPIFacade::getInstance()->addAction('gd_createupdate_post:update', array($this, 'sendemailToAdminUpdatepost'), 100, 1);
        HooksAPIFacade::getInstance()->addAction('gd_createupdate_post:create', array($this, 'sendemailToAdminCreatepost'), 100, 1);
        
        //----------------------------------------------------------------------
        // Email Notifications
        //----------------------------------------------------------------------
        // Late priority, so they send the email if PoP SocialNetwork has not done so before
        HooksAPIFacade::getInstance()->addAction('gd_createupdate_post:create', array($this, 'emailnotificationsGeneralNewpostCreate'), 100, 1);
        HooksAPIFacade::getInstance()->addAction('gd_createupdate_post:update', array($this, 'emailnotificationsGeneralNewpostUpdate'), 100, 2);

        //----------------------------------------------------------------------
        // Functional emails
        //----------------------------------------------------------------------
        // Post created/updated/approved
        HooksAPIFacade::getInstance()->addAction('gd_createupdate_post:create', array($this, 'sendemailToUsersFromPostCreate'), 100, 1);
        HooksAPIFacade::getInstance()->addAction(
            'popcms:pendingToPublish', 
            array($this, 'sendemailToUsersFromPostPostapproved'), 
            10, 
            1
        );
        HooksAPIFacade::getInstance()->addAction('gd_createupdate_post:create', array($this, 'sendemailToUsersFromPostReferencescreate'), 10, 1);
        HooksAPIFacade::getInstance()->addAction('gd_createupdate_post:update', array($this, 'sendemailToUsersFromPostReferencesupdate'), 10, 2);
        HooksAPIFacade::getInstance()->addAction(
            'popcms:pendingToPublish', 
            array($this, 'sendemailToUsersFromPostReferencestransition'), 
            10, 
            1
        );
    }

    /**
     * Send email to admin when post created/updated
     */
    // Send an email to the admin also. // Copied from WPUF
    public function sendemailToAdminCreatepost($post_id)
    {
        $this->sendemailToAdminCreateupdatepost($post_id, 'create');
    }
    public function sendemailToAdminUpdatepost($post_id)
    {
        $this->sendemailToAdminCreateupdatepost($post_id, 'update');
    }
    protected function sendemailToAdminCreateupdatepost($post_id, $type)
    {
        $cmsapplicationapi = \PoP\Application\FunctionAPIFactory::getInstance();
        $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
        $cmspostsapi = PostTypeAPIFacade::getInstance();
        $blogname = $cmsapplicationapi->getSiteName();
        $to = PoP_EmailSender_Utils::getAdminNotificationsEmail();
        $permalink = $cmspostsapi->getPermalink($post_id);
        $post_name = gdGetPostname($post_id);
        $post_author_id = get_post_field('post_author', $post_id);
        $author_name = $cmsusersapi->getUserDisplayName($post_author_id);
        $author_email = $cmsusersapi->getUserEmail($post_author_id);

        if ($type == 'create') {
            $subject = sprintf(
                TranslationAPIFacade::getInstance()->__('[%s]: New %s by %s', 'pop-emailsender'),
                $blogname,
                $post_name,
                $author_name
            );
            $msg = sprintf(
                TranslationAPIFacade::getInstance()->__('A new %s has been submitted on %s:', 'pop-emailsender'),
                $post_name,
                $blogname
            );
        } elseif ($type == 'update') {
            $subject = sprintf(
                TranslationAPIFacade::getInstance()->__('[%s]: %s updated by %s', 'pop-emailsender'),
                $blogname,
                $post_name,
                $author_name
            );
            $msg = sprintf(
                TranslationAPIFacade::getInstance()->__('%s updated on %s:', 'pop-emailsender'),
                $post_name,
                $blogname
            );
        }

        $msg .= "<br/><br/>";
        $msg .= sprintf(
            TranslationAPIFacade::getInstance()->__('<b>Author:</b> %s', 'pop-emailsender'),
            $author_name
        ) . "<br/>";
        $msg .= sprintf(
            TranslationAPIFacade::getInstance()->__('<b>Author Email:</b> <a href="mailto:%1$s">%1$s</a>', 'pop-emailsender'),
            $author_email
        ) . "<br/>";
        $msg .= sprintf(
            TranslationAPIFacade::getInstance()->__('<b>Title:</b> %s', 'pop-emailsender'),
            $cmspostsapi->getTitle($post_id)
        ) . "<br/>";
        $msg .= sprintf(
            TranslationAPIFacade::getInstance()->__('<b>Permalink:</b> <a href="%1$s">%1$s</a>', 'pop-emailsender'),
            $permalink
        ) . "<br/>";
        $msg .= sprintf(
            TranslationAPIFacade::getInstance()->__('<b>Edit Link:</b> <a href="%1$s">%1$s</a>', 'pop-emailsender'),
            admin_url('post.php?action=edit&post='.$post_id)
        ) . "<br/>";
        $msg .= sprintf(
            TranslationAPIFacade::getInstance()->__('<b>Status:</b> %s', 'pop-emailsender'),
            $cmspostsapi->getPostStatus($post_id)
        );

        PoP_EmailSender_Utils::sendEmail($to, $subject, $msg);
    }

    /**
     * Create / Update Post
     */
    // Send an email to all post owners when a post is created
    public function sendemailToUsersFromPostCreate($post_id)
    {

        // Check if for a given type of post the email must not be sent (eg: Highlights)
        if (PoP_EmailSender_Utils::sendemailSkip($post_id)) {
            return;
        }

        $cmspostsapi = PostTypeAPIFacade::getInstance();
        $cmseditpostsapi = \PoP\EditPosts\FunctionAPIFactory::getInstance();
        $status = $cmspostsapi->getPostStatus($post_id);
        
        $post_name = gdGetPostname($post_id);
        $subject = sprintf(TranslationAPIFacade::getInstance()->__('Your %s was created successfully!', 'pop-emailsender'), $post_name);
        $content = ($status == POP_POSTSTATUS_PUBLISHED) ?
        sprintf(
            '<p>%s</p>',
            sprintf(
                TranslationAPIFacade::getInstance()->__('Your %s was created successfully!', 'pop-emailsender'),
                $post_name
            )
        ) :
        sprintf(
            TranslationAPIFacade::getInstance()->__('<p>Your %s <a href="%s">%s</a> was created successfully!</p>', 'pop-emailsender'),
            $post_name,
            $cmseditpostsapi->getEditPostLink($post_id),
            $cmspostsapi->getTitle($post_id)
        );

        if ($status == POP_POSTSTATUS_PUBLISHED) {
            $content .= PoP_EmailTemplatesFactory::getInstance()->getPosthtml($post_id);
        } elseif ($status == POP_POSTSTATUS_DRAFT) {
            $content .= sprintf(
                '<p><em>%s</em></p>',
                sprintf(
                    // TranslationAPIFacade::getInstance()->__('Please notice that the status of the %s is still <strong>\'Draft\'</strong>, it must be changed to <strong>\'Finished editing\'</strong> to have the website admins publish it.', 'pop-emailsender'),
                    TranslationAPIFacade::getInstance()->__('Please notice that the status of the %s is <strong>\'Draft\'</strong>, so it won\'t be published online.', 'pop-emailsender'),
                    $post_name
                )
            );
        } elseif ($status == POP_POSTSTATUS_PENDING) {
            $content .= TranslationAPIFacade::getInstance()->__('<p>Please wait for our moderators approval. You will receive an email with the confirmation.</p>');
        }

        $authors = PoP_EmailSender_Utils::sendemailToUsersFromPost($post_id, $subject, $content, PoP_EmailSender_SentEmailsManager::getSentemailUsers(POP_EMAIL_CREATEDCONTENT));

        // Add the users to the list of users who got an email sent to
        PoP_EmailSender_SentEmailsManager::addSentemailUsers(POP_EMAIL_CREATEDCONTENT, $authors);
    }

    /**
     * General (all users): post created
     */
    // Send an email to all users when a post is published
    public function emailnotificationsGeneralNewpostCreate($post_id)
    {
        
        // Send email if the created post has been published
        $cmspostsapi = PostTypeAPIFacade::getInstance();
        if ($cmspostsapi->getPostStatus($post_id) == POP_POSTSTATUS_PUBLISHED) {
            $this->sendemailEmailnotificationsGeneralNewpost($post_id);
        }
    }
    public function emailnotificationsGeneralNewpostUpdate($post_id, $log)
    {
        
        // Send an email to all users when a post is published
        $old_status = $log['previous-status'];

        // Send email if the updated post has been published
        $cmspostsapi = PostTypeAPIFacade::getInstance();
        if ($cmspostsapi->getPostStatus($post_id) == POP_POSTSTATUS_PUBLISHED && $old_status != POP_POSTSTATUS_PUBLISHED) {
            $this->sendemailEmailnotificationsGeneralNewpost($post_id);
        }
    }
    protected function sendemailEmailnotificationsGeneralNewpost($post_id)
    {

        // Check if for a given type of post the email must not be sent (eg: Highlights)
        if (PoP_EmailSender_Utils::sendemailSkip($post_id)) {
            return;
        }

        // Keep only the users with the corresponding preference on
        // Do not send to the current user
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $users = PoP_UserPlatform_UserPreferencesUtils::getPreferenceonUsers(POP_USERPREFERENCES_EMAILNOTIFICATIONS_GENERAL_NEWPOST, array(), array($vars['global-userstate']['current-user-id']));
        if ($users) {
            // From those, remove all users who got an email in a previous email function
            if ($users = array_diff($users, PoP_EmailSender_SentEmailsManager::getSentemailUsers(POP_EMAIL_CREATEDCONTENT))) {
                $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
                $cmspostsapi = PostTypeAPIFacade::getInstance();

                $emails = $names = array();
                foreach ($users as $user) {
                    $emails[] = $cmsusersapi->getUserEmail($user);
                    $names[] = $cmsusersapi->getUserDisplayName($user);
                }

                // No need to check if the post_status is "published", since it's been checked in the previous 2 functions (create/update)
                $post_html = PoP_EmailTemplatesFactory::getInstance()->getPosthtml($post_id);
                $post_name = gdGetPostname($post_id);
                $post_title = $cmspostsapi->getTitle($post_id);
                $footer = PoP_UserPlatform_EmailSenderUtils::getPreferencesFooter(TranslationAPIFacade::getInstance()->__('You are currently receiving notifications for all new content posted on the website.', 'pop-emailsender'));

                $cmspostsresolver = \PoP\Posts\ObjectPropertyResolverFactory::getInstance();
                $post = $cmspostsapi->getPost($post_id);
                $author = $cmspostsresolver->getPostAuthor($post);
                $author_name = $cmsusersapi->getUserDisplayName($author);
                $author_url = $cmsusersapi->getUserURL($author);
                $subject = sprintf(
                    TranslationAPIFacade::getInstance()->__('There is a new %s: “%s”', 'pop-emailsender'),
                    $post_name,
                    $post_title
                );
                $content = sprintf(
                    '<p>%s</p>',
                    sprintf(
                        TranslationAPIFacade::getInstance()->__('<b><a href="%s">%s</a></b> has created a new %s:', 'pop-emailsender'),
                        $author_url,
                        $author_name,
                        $post_name
                    )
                );
                $content .= $post_html;
                $content .= $footer;

                PoP_EmailSender_Utils::sendemailToUsers($emails, $names, $subject, $content, true);

                // Add the users to the list of users who got an email sent to
                PoP_EmailSender_SentEmailsManager::getSentemailUsers(POP_EMAIL_CREATEDCONTENT, $users);
            }
        }
    }

    /**
     * Send Email when post is approved
     */
    public function sendemailToUsersFromPostReferencesupdate($post_id, $log)
    {
        $old_status = $log['previous-status'];

        // Send email if the updated post has been published
        $cmspostsapi = PostTypeAPIFacade::getInstance();
        if ($cmspostsapi->getPostStatus($post_id) == POP_POSTSTATUS_PUBLISHED && $old_status != POP_POSTSTATUS_PUBLISHED) {
            $this->sendemailToUsersFromPostReferences($post_id);
        }
    }
    public function sendemailToUsersFromPostReferencescreate($post_id)
    {

        // Send email if the created post has been published
        $cmspostsapi = PostTypeAPIFacade::getInstance();
        if ($cmspostsapi->getPostStatus($post_id) == POP_POSTSTATUS_PUBLISHED) {
            $this->sendemailToUsersFromPostReferences($post_id);
        }
    }
    public function sendemailToUsersFromPostReferencestransition($post)
    {
        $cmspostsresolver = \PoP\Posts\ObjectPropertyResolverFactory::getInstance();
        $this->sendemailToUsersFromPostReferences($cmspostsresolver->getPostId($post));
    }
    protected function sendemailToUsersFromPostReferences($post_id)
    {
        $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
        $cmspostsapi = PostTypeAPIFacade::getInstance();
        $cmsapplicationpostsapi = \PoP\Application\PostsFunctionAPIFactory::getInstance();
        $skip = !in_array($cmspostsapi->getPostType($post_id), $cmsapplicationpostsapi->getAllcontentPostTypes());

        // Check if for a given type of post the email must not be sent (eg: Highlights)
        if (HooksAPIFacade::getInstance()->applyFilters('post_references:skip_sendemail', $skip, $post_id)) {
            return;
        }

        // Check if the post has references. If so, also send email to the owners of those
        if ($references = \PoP\PostMeta\Utils::getPostMeta($post_id, GD_METAKEY_POST_REFERENCES)) {
            $post_name = gdGetPostname($post_id);
            $url = $cmspostsapi->getPermalink($post_id);
            $title = $cmspostsapi->getTitle($post_id);
            $post_html = PoP_EmailTemplatesFactory::getInstance()->getPosthtml($post_id);

            // Get the name of the poster
            $post_author_id = get_post_field('post_author', $post_id);
            $author_name = $cmsusersapi->getUserDisplayName($post_author_id);

            foreach ($references as $reference_post_id) {
                $reference_post_name = gdGetPostname($reference_post_id);
                $reference_url = $cmspostsapi->getPermalink($reference_post_id);
                $reference_title = $cmspostsapi->getTitle($reference_post_id);

                $reference_subject = sprintf(
                    TranslationAPIFacade::getInstance()->__('A new %s was posted referencing "%s"', 'pop-emailsender'),
                    $post_name,
                    $reference_title
                );
                $reference_content = sprintf(
                    TranslationAPIFacade::getInstance()->__('<p>Your %s <a href="%s">%s</a> has been referenced by a new %s:</p>', 'pop-emailsender'),
                    $reference_post_name,
                    $reference_url,
                    $reference_title,
                    $post_name
                );
                $reference_content .= $post_html;

                $authors = PoP_EmailSender_Utils::sendemailToUsersFromPost($reference_post_id, $reference_subject, $reference_content, PoP_EmailSender_SentEmailsManager::getSentemailUsers(POP_EMAIL_CREATEDCONTENT));

                // Add the users to the list of users who got an email sent to
                PoP_EmailSender_SentEmailsManager::addSentemailUsers(POP_EMAIL_CREATEDCONTENT, $authors);
            }
        }
    }

    public function sendemailToUsersFromPostPostapproved($post)
    {
        $cmspostsresolver = \PoP\Posts\ObjectPropertyResolverFactory::getInstance();
        $post_id = $cmspostsresolver->getPostId($post);

        $cmspostsapi = PostTypeAPIFacade::getInstance();
        $post_name = gdGetPostname($post_id);
        $url = $cmspostsapi->getPermalink($post_id);
        $title = $cmspostsapi->getTitle($post_id);
        $post_html = PoP_EmailTemplatesFactory::getInstance()->getPosthtml($post_id);

        $subject = sprintf(TranslationAPIFacade::getInstance()->__('Your %s was approved!', 'pop-emailsender'), $post_name);
        $content = sprintf(
            TranslationAPIFacade::getInstance()->__('<p>Hurray! Your %s was approved!</p>', 'pop-emailsender'),
            $post_name
        );
        $content .= $post_html;

        $authors = PoP_EmailSender_Utils::sendemailToUsersFromPost($post_id, $subject, $content, PoP_EmailSender_SentEmailsManager::getSentemailUsers(POP_EMAIL_CREATEDCONTENT));

        // Add the users to the list of users who got an email sent to
        PoP_EmailSender_SentEmailsManager::addSentemailUsers(POP_EMAIL_CREATEDCONTENT, $authors);
    }
}

/**
 * Initialization
 */
new PoP_ContentCreation_EmailSender_Hooks();
