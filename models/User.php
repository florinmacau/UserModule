<?php
/**
 * Represents the User entity having the user table columns as member variables
 */
class Model_User
{
    /**
     * User id
     * 
     * @var int
     */
    protected $id;
    
    /**
     * Username
     * 
     * @var string
     */
    protected $username;
    
    /**
     * Password hash
     * 
     * @var string
     */
    protected $passwordHash;
    
    /**
     * Email
     * 
     * @var string
     */
    protected $email;
    
    /**
     * Display name
     * 
     * @var string
     */
    protected $displayName;
    
    /**
     * Constructor
     * Initializes the User object with the values given by array parameter
     * 
     * @param type $validValues
     */
    public function __construct($validValues)
    {
        if (isset($validValues["id"])) {
            $this->setId($validValues["id"]);
            $this->setPasswordHash($validValues["passwordHash"]);
        } else {
            $this->setPasswordHash(Service_UserAuth::getHash($validValues["password"]));
        } 
        $this->setUsername($validValues["username"]);
        $this->setDisplayName($validValues["displayName"]);
        $this->setEmail($validValues["email"]);
        
    }
    
    /**
     * Returns the user id for the object
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
    * Returns the username for the object
    * 
    * @return string
    */
    public function getUsername()
    {
        return $this->username;
    }

    /**
    * Returns the password hash for the object
    * 
    * @return string
    */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
    * Returns the email for the object
    * 
    * @return string
    */
    public function getEmail()
    {
        return $this->email;
    }

    /**
    * Returns the email for the object
    * 
    * @return string
    */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
    * Sets the user id for the object
    * 
    * @param int $id
    */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
    * Sets the username for the object
    * 
    * @param string $username
    */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
    * Sets the password hash for the object
    * 
    * @param string $passwordHash
    */
    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = $passwordHash;
    }

    /**
    * Sets the email for the object
    * 
    * @param string $email
    */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
    * Sets the display name for the object
    * 
    * @param string $displayName
    */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    
    /**
    * Returns an array with the member variables of the stdClass given by parameter
    * 
    * Returned array structure:
    * array(
    *   'id'           => int,
    *   'username'     => string,
    *   'email'        => string,
    *   'passwordHash' => string,
    *   'displayName'  => string
    * )
    * @param stdClass $user
    * 
    * @return array
    */    
    public static function getArrayFromStorage(stdClass $user)
    {
        $array                 = array();
        $array['id']           = $user->Id;
        $array['username']     = $user->Username;
        $array['email']        = $user->Email;
        $array['passwordHash'] = $user->PasswordHash;
        $array['displayName']  = $user->DisplayName;
        return $array;
    }
}
