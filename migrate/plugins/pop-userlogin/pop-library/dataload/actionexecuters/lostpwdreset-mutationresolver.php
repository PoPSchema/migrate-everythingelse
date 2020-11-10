<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Misc\GeneralUtils;
use PoP\ComponentModel\MutationResolvers\ErrorTypes;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;
use PoP\ComponentModel\Error;

class GD_LostPwdReset extends AbstractMutationResolver
{
    public function getErrorType(): int
    {
        return ErrorTypes::CODES;
    }

    public function validateErrors(array $form_data): ?array
    {
        $errorcodes = array();
        $code = $form_data['code'];
        $pwd = $form_data['pwd'];
        $repeatpwd = $form_data['repeatpwd'];

        if (!$code) {
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
        return $errorcodes;
    }
    public function execute(array $form_data)
    {
        $code = $form_data['code'];
        $pwd = $form_data['pwd'];

        $cmsuseraccountapi = \PoP\UserAccount\FunctionAPIFactory::getInstance();
        $decoded = GD_LostPasswordUtils::decodeCode($code);
        $rp_key = $decoded['key'];
        $rp_login = $decoded['login'];

        if (!$rp_key || !$rp_login) {
            return new Error(
                'error-wrongcode'
            );
        } else {
            $user = $cmsuseraccountapi->checkPasswordResetKey($rp_key, $rp_login);
            if (!$user) {
                return new Error(
                    'error-invalidkey'
                );
            }
            if (GeneralUtils::isError($user)) {
                return $user;
            }
        }

        // Do the actual password reset
        $cmsuseraccountapi->resetPassword($user, $pwd);

        $cmsusersresolver = \PoPSchema\Users\ObjectPropertyResolverFactory::getInstance();
        $userID = $cmsusersresolver->getUserId($user);
        HooksAPIFacade::getInstance()->doAction('gd_lostpasswordreset', $userID);
        return $userID;
    }
}
