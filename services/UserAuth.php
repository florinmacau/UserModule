<?php
/**
 * Represents the class that provides methods used for user authentication 
 */
class Service_UserAuth
{
    const BCRYPT_SALT = "userModule19njsnasd521";

    /**
     * Returns the authentication adapter for identity and credential given by parameter having the purpose to verify
     * the user access
     * 
     * @param string $identity
     * @param string $credential
     * @return \Zend_Auth_Adapter_DbTable
     */
    public static function getAuthenticationAdapter($identity, $credential)
    {

        static $authAdapter;

        if ($authAdapter instanceof Zend_Auth_Adapter_DbTable) {
            return $authAdapter;
        } else {
            $authAdapter = new Zend_Auth_Adapter_DbTable();
            $authAdapter->setTableName('Users')
                        ->setIdentityColumn('Username')
                        ->setCredentialColumn('PasswordHash');
            $authAdapter->setIdentity($identity)
                        ->setCredential($credential);
            return $authAdapter;
        }
    }
    
    /**
     * Returns the Bcrypt password hash for the string given by parameter
     * 
     * @param string $password
     * @return string
     */    
    public static function getHash($password)
    {
        $optionsForHash = [ "salt" => static::BCRYPT_SALT];
        return password_hash($password, PASSWORD_BCRYPT, $optionsForHash);
    }
}
