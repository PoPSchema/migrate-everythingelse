<?php

class PoP_Mailer_AWS_ServerUtils
{
    public static function sendEmailsDisabled()
    {
        return isset($_ENV['DISABLE_SENDING_EMAILS_BY_AWS_SES']) ? strtolower($_ENV['DISABLE_SENDING_EMAILS_BY_AWS_SES']) == "true" : false;
    }
}
