<?php
/**
 * Represents the class that provides information from the database
 */
class Model_UserMapper
{
    /**
     * Contains the name of the user table
     * 
     * @var const
     */
    const table = 'Users';
    
    /**
     * Contains the adapter for queries
     * 
     * @var Zend_Db_Adapter_Abstract
     */
    protected $dbConnection;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dbConnection = Zend_Db_Table::getDefaultAdapter();
    }

    /**
     * Returns the information from the table for the searched user given by parameter
     * If the given user does not exist, an empty array will be returned
     * 
     * @param string $username
     * @return array
     */
    public function getUserByUsername($username)
    {
        $select = $this->dbConnection->select()
                       ->from(static::table) 
                       ->where('username = ?', $username);
        return $this->dbConnection->query($select)->fetchAll();
    }

    /**
     * Returns the information from the table for the searched email given by parameter
     * If the given email does not exist, an empty array will be returned
     * 
     * @param string $email
     * @return array
     */    
    public function getUserByEmail($email)
    {
        $select = $this->dbConnection->select()
                       ->from(static::table)
                       ->where('email = ?', $email);
        return $this->dbConnection->query($select)->fetchAll();
    }

    /**
     * Inserts the user object given by parameter into the table
     * 
     * @param Model_User $user
     */
    public function insertUser(Model_User $user)
    {
        $data = array(
            'Username'     => $user->getUsername(),
            'DisplayName'  => $user->getDisplayName(),
            'Email'        => $user->getEmail(),
            'PasswordHash' => $user->getPasswordHash()
        );

        $this->dbConnection->insert(static::table, $data);

    }

    /**
     * Updates the column given by parameter in the table for the user given by parameter
     * 
     * @param Model_User $user
     * @param string $columnForChange
     */    
    public function updateUser(Model_User $user, $columnForChange)
    {
        $data = array(
            'Id'           => $user->getId(),
            'Username'     => $user->getUsername(),
            'DisplayName'  => $user->getDisplayName(),
            'Email'        => $user->getEmail(),
            'PasswordHash' => $user->getPasswordHash()
        );

        if ($columnForChange == 'password') {
            $this->dbConnection->update(static::table,
                                        array('PasswordHash' => $data['PasswordHash']),
                                        array('Id = ?' => $data['Id']));
        } else if ($columnForChange == 'email') {
            $this->dbConnection->update(static::table,
                                        array('Email' => $data['Email']),
                                        array('Id = ?' => $data['Id']));
        }
    }
}
