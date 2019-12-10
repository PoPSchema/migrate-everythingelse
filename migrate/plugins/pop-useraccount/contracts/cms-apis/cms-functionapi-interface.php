<?php
namespace PoP\UserAccount;

interface FunctionAPI
{
    public function login($credentials);
    public function logout();
    public function isUserLoggedIn();
    public function getCurrentUser();
    public function getCurrentUserId();
    public function checkPassword($user_id, $password);
    public function checkPasswordResetKey($key, $login);
    public function resetPassword($user, $pwd);
    public function getPasswordResetKey($user_data);
    public function getLoginURL();
    public function getLogoutURL();
    public function getLostPasswordURL();
}
