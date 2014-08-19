<?php
/**
 * Represents the main controller of the module
 */
class UserController extends Zend_Controller_Action
{
    const INDEXROUTE          = 'index';
    const REGISTERROUTE       = 'register';
    const LOGINROUTE          = 'login';
    const CHANGEPASSWORDROUTE = 'change-password';
    const CHANGEEMAILROUTE    = 'change-email';

    public function indexAction()
    {
    }
    
    public function registerAction()
    {
        $auth = Zend_Auth::getInstance(); //puts identity object that contains the user information in $auth
        if ($auth->getIdentity()) { //if user is authenticated
            $this->_helper->redirector(static::INDEXROUTE); //redirects to index route
        }

        $form = new Form_Register(); //form for register
        if ($this->getRequest()->isPost()) { //if request method is post
            $post = $this->getRequest()->getParams(); //copies the sent parameters to the $post variable
            if ($form->isValid($post)) { //if the form post is valid
                //copies the valid values passed through post to $validValues
                $validValues = $form->getValidValues($post);
                $user        = new Model_User($validValues); //creates a user model and copies the valid post values into it
                $userMapper  = new Model_UserMapper(); //creates a user mapper to use its model methods  
                $userMapper->insertUser($user); //inserts the user in database

                $flashMessenger = $this->_helper->FlashMessenger; //puts the flash messenger in $flashMessenger
                $flashMessenger->setNamespace('success')->addMessage('User created'); //adds message in namespace
                $this->_helper->redirector(static::REGISTERROUTE); //redirects to login route
            }
        }
        $this->view->form = $form; //pass the form to view
    }

    public function loginAction()
    {
        $auth = Zend_Auth::getInstance(); //puts identity object that contains the user information in $auth
        if ($auth->getIdentity()) { //if user is authenticated
            $this->_helper->redirector(static::INDEXROUTE); //redirects to index route
        }

        $form = new Form_Login(); //form for login
        if ($this->getRequest()->isPost()) { //if request method is post
            $post = $this->getRequest()->getParams(); //copies the sent parameters to the $post variable
            if ($form->isValid($post)) { //if the form post is valid
                //copies the valid values passed through post to $validValues
                $validValues = $form->getValidValues($post);
                /* puts the authentication adapter in $authenticationAdapter by passing the posted credentials to
                getAuthenticationAdapter static method */
                $authenticationAdapter = Service_UserAuth::getAuthenticationAdapter(
                                                            $validValues["username"],
                                                            Service_UserAuth::getHash($validValues["password"]));
                //puts the authentication result in $result
                $result = $auth->authenticate($authenticationAdapter);
                if ($result->isValid()) { //if result is valid
                    //put the information about the logged user as row object in $user
                    $user = $authenticationAdapter->getResultRowObject();
                    $auth->getStorage()->write($user); //write the row object in storage

                    $flashMessenger = $this->_helper->FlashMessenger; //puts the flash messenger in $flashMessenger
                    //adds message in namespace
                    $flashMessenger->setNamespace('success')->addMessage('Login successful');
                    $this->_helper->redirector(static::INDEXROUTE); //redirects to index route
                } else {
                    $flashMessenger = $this->_helper->FlashMessenger; //puts the flash messenger in $flashMessenger
                    //adds message in namespace
                    $flashMessenger->setNamespace('error')->addMessage('Invalid credentials');
                    $this->_helper->redirector(static::LOGINROUTE); //redirects to login route
                }
            }
        }
        $this->view->form = $form; //pass the form to view
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance(); //puts identity object that contains the user information in $auth
        if ($auth->getIdentity()) { //if user is authenticated
            $auth->clearIdentity(); //clears the identity object

            $flashMessenger = $this->_helper->FlashMessenger; //puts the flash messenger in $flashMessenger
            $flashMessenger->setNamespace('success')->addMessage('Logout successful'); //adds message in namespace
            $this->_helper->redirector(static::INDEXROUTE); //redirects to index route
        } else {
            $this->_helper->redirector(static::INDEXROUTE); //redirects to index route
        }
    }
    
    public function changePasswordAction()
    {
        $auth = Zend_Auth::getInstance(); //puts identity object that contains the user information in $auth
        if (!$auth->getIdentity()) { //if user is not authenticated
            $this->_helper->redirector(static::INDEXROUTE); //redirects to index action
        }

        $form = new Form_ChangePassword(); //form for password change
        if ($this->getRequest()->isPost()) { //if request method is post
            $post = $this->getRequest()->getParams(); //copies the sent parameters to the $post variable
            if ($form->isValid($post)) { //if the form post is valid
                //copies the valid values passed through post to $validValues
                $validValues = $form->getValidValues($post);
                //creates a user model and copies into it the information about the logged user
                $user = new Model_User(Model_User::getArrayFromStorage($auth->getStorage()->read()));
                //sets the password for user model
                $user->setPasswordHash(Service_UserAuth::getHash($validValues["password"]));
                $userMapper = new Model_UserMapper(); //creates a user mapper to use its model methods
                //updates the user password in database for the user model passed by parameter
                $userMapper->updateUser($user, 'password');
                //sets the password property for identity object
                $auth->getIdentity()->PasswordHash = $user->getPasswordHash();

                $flashMessenger = $this->_helper->FlashMessenger; //puts the flash messenger in $flashMessenger
                $flashMessenger->setNamespace('success')->addMessage('Password changed'); //adds message in namespace
                $this->_helper->redirector(static::CHANGEPASSWORDROUTE); //redirects to change password route
            }
        }
        $this->view->form = $form; //pass the form to view
    }

    public function changeEmailAction()
    {
        $auth = Zend_Auth::getInstance(); //puts identity object that contains the user information in $auth
        if (!$auth->getIdentity()) { //if user is not authenticated
            $this->_helper->redirector(static::INDEXROUTE); //redirects to index action
        }

        $form = new Form_ChangeEmail(); //form for email change
        if ($this->getRequest()->isPost()) { //if request method is post
            $post = $this->getRequest()->getParams(); //copies the sent parameters to the $post variable
            if ($form->isValid($post)) { //if the form post is valid
                //copies the valid values passed through post to $validValues
                $validValues = $form->getValidValues($post);
                //creates a user model and copies into it the information about the logged user
                $user = new Model_User(Model_User::getArrayFromStorage($auth->getStorage()->read()));
                $user->setEmail($validValues["email"]); //sets the email for user model
                $userMapper = new Model_UserMapper(); //creates a user mapper to use its model methods
                //updates the user email in database for the user model passed by parameter
                $userMapper->updateUser($user, 'email');
                $auth->getIdentity()->Email = $user->getEmail(); //sets the email property for identity object

                $flashMessenger = $this->_helper->FlashMessenger; //puts the flash messenger in $flashMessenger
                $flashMessenger->setNamespace('success')->addMessage('Email changed'); //adds message in namespace
                $this->_helper->redirector(static::CHANGEEMAILROUTE); //redirects to change email route
            }
        }
        $this->view->form = $form; //pass the form to view
    }
}
