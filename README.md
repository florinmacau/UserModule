UserModule
======
Created by Florin Măcău

##About
UserModule is a simple user registration and authentication Zend Framework 1 module.

This module serves as a simple example for starting developing ZF1 applications.

##Features
* User registration
* User login
* User password change
* User email
* User logout

##Requirements
- Zend Framework version (latest)
- (optional) This module needs Twitter Bootstrap v3 in the "public" directory

##Installation
  1.Your ZF1 app has to mantain (more or less) the following folder structure:
```
|-- application
|   |-- configs
|   `-- modules
|-- docs
|-- library
`-- public
```
  2.The UserModule has to be cloned in the "modules" directory

##Security
The UserModule module uses the Bcrypt hash algorithm, and has a predefined salt. Feel yourself free to modify the salt to increase security.
