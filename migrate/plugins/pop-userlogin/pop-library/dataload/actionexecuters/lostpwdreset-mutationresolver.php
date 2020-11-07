<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Misc\GeneralUtils;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;

class GD_LostPwdReset implements MutationResolverInterface
{
    public function execute(array &$errors, array &$errorcodes, array $form_data)
    {
        $code = $form_data['code'];
        $pwd = $form_data['pwd'];
        $repeatpwd = $form_data['repeatpwd'];

        $cmsuseraccountapi = \PoP\UserAccount\FunctionAPIFactory::getInstance();
        $errorcodes = array();
        if ($code) {
            $decoded = GD_LostPasswordUtils::decodeCode($code);
            $rp_key = $decoded['key'];
            $rp_login = $decoded['login'];

            if (!$rp_key || !$rp_login) {
                $errorcodes[] = 'error-wrongcode';
            } else {
                $user = $cmsuseraccountapi->checkPasswordResetKey($rp_key, $rp_login);
                if (!$user || GeneralUtils::isError($user)) {
                    $errorcodes[] = 'error-invalidkey';
                }
            }
        } else {
            $errorcodes[] = 'error-nocode';
        }

        if (!$pwd) {
            $errorcodes[] = 'error-nopwd';
        } elseif (strlen($pwd) < 8) {
            $errorcodes[] = 'error-short';
        }
        if (!$repeatpwd) {
            $errorcodes[] = 'error-norepeatpwd';
        }
        if ($pwd != $repeatpwd) {
            $errorcodes[] = 'error-pwdnomatch';
        }

        // Return error string
        if ($errorcodes) {
            return;
        }

        // Do the actual password reset
        $cmsuseraccountapi->resetPassword($user, $pwd);

        $cmsusersresolver = \PoPSchema\Users\ObjectPropertyResolverFactory::getInstance();
        HooksAPIFacade::getInstance()->doAction('gd_lostpasswordreset', $cmsusersresolver->getUserId($user));
    }
}
