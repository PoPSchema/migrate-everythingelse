<?php
namespace PoP\EditUsers\WP;

class FunctionAPI extends \PoP\EditUsers\FunctionAPI_Base
{
    public function insertUser($user_data)
    {
        $this->convertQueryArgsFromPoPToCMSForInsertUpdateUser($user_data);
        $result = wp_insert_user($user_data);
        return \PoP\Application\Utils::returnResultOrConvertError($result);
    }
    public function updateUser($user_data)
    {
        $this->convertQueryArgsFromPoPToCMSForInsertUpdateUser($user_data);
        $result = wp_update_user($user_data);
        return \PoP\Application\Utils::returnResultOrConvertError($result);
    }
}

/**
 * Initialize
 */
new FunctionAPI();
