prerequis: symfony https://symfony.com/download

create project : symfony new -webapp "symfony-start"

composer v2 :

composer require symfony/webpack-encore-bundle
composer require symfony/doctrine-messenger
composer require symfony/browser-kit
composer require symfony/orm-pack
composer require symfony/maker-bundle --dev

Création de la base de données et du user
Modification du .env


VERIF : 
php bin/console list
php bin/console doctrine:migration:status


CREATION DES ENTITES :

 Class name of the entity to create or update (e.g. BravePuppy):
 > Message  

 created: src/Entity/Message.php
 created: src/Repository/MessageRepository.php
 
 New property name (press <return> to stop adding fields): Title
 Field type (enter ? to see all types) [string]:
 Field length [255]:
 Can this field be null in the database (nullable) (yes/no) [no]:

 Add another property? Enter the property name (or press <return> to stop adding fields): Body
 Field type (enter ? to see all types) [string]: text
 Can this field be null in the database (nullable) (yes/no) [no]:

 Add another property? Enter the property name (or press <return> to stop adding fields): EmissionDate
 Field type (enter ? to see all types) [string]: datetime
 Can this field be null in the database (nullable) (yes/no) [no]: yes

 Add another property? Enter the property name (or press <return> to stop adding fields): Status
 Field type (enter ? to see all types) [string]: boolean
 Can this field be null in the database (nullable) (yes/no) [no]:

 Add another property? Enter the property name (or press <return> to stop adding fields): SendingDate
 Field type (enter ? to see all types) [string] : datetime
 Can this field be null in the database (nullable) (yes/no) [no]: yes
 
 Add another property? Enter the property name (or press <return> to stop adding fields): Choice
 Field type (enter ? to see all types) [string]:
 Field length [255]:
 Can this field be null in the database (nullable) (yes/no) [no]:

 updated: src/Entity/Message.php
 Next: When you're ready, create a migration with php bin/console make:migration


php bin/console make:controller
Choose a name for your controller class (e.g. GrumpyElephantController): MessageController





BDD :

* php bin/console make:migration
* php bin/console doctrine:migration:migrate


LISTE DES MESSAGES
* php bin/console doctrine:query:sql 'SELECT * FROM message'

COMMANDE :
* php bin/console make:command


USERS et SECURITE
* php bin/console make:user

 The name of the security user class (e.g. User) [User]:
 Do you want to store user data in the database (via Doctrine)? (yes/no) [yes]:
 Enter a property name that will be the unique "display" name for the user (e.g. email, username, uuid) [email]:
 Will this app need to hash/check user passwords? Choose No if passwords are not needed or will be checked/hashed by some other system (e.g. a single sign-on server).
Does this app need to hash/check user passwords? (yes/no) [yes]:
 created: src/Entity/User.php
 created: src/Repository/UserRepository.php
 updated: src/Entity/User.php
 updated: config/packages/security.yaml

 Next Steps:
   - Review your new App\Entity\User class.
   - Use make:entity to add more fields to your User entity and then run make:migration.
   - Create a way to authenticate! See https://symfony.com/doc/current/security.html


php bin/console make:user

 The name of the security user class (e.g. User) [User]:
 >

 Do you want to store user data in the database (via Doctrine)? (yes/no) [yes]:
 >

 Enter a property name that will be the unique "display" name for the user (e.g. email, username, uuid) [email]:
 >

 Will this app need to hash/check user passwords? Choose No if passwords are not needed or will be checked/hashed by some other system (e.g. a single sign-on server).

 Does this app need to hash/check user passwords? (yes/no) [yes]:
 >

 created: src/Entity/User.php
 created: src/Repository/UserRepository.php
 updated: src/Entity/User.php
 updated: config/packages/security.yaml

 
  Success! 


 Next Steps:
   - Review your new App\Entity\User class.
   - Use make:entity to add more fields to your User entity and then run make:migration.
   - Create a way to authenticate! See https://symfony.com/doc/current/security.html

* php bin/console make:entity

 Class name of the entity to create or update (e.g. DeliciousPopsicle):
 > User

 Your entity already exists! So let's add some new fields!

 nom
 Field type (enter ? to see all types) [string]:
 Field length [255]:
 Can this field be null in the database (nullable) (yes/no) [no]:

 prenom
 Field type (enter ? to see all types) [string]:
 Field length [255]:
 Can this field be null in the database (nullable) (yes/no) [no]:

* php bin/console make:migration
* php bin/console doctrine:migration:migrate



* php bin/console make:auth

 What style of authentication do you want? [Empty authenticator]:  [1] Login form authenticator
 The class name of the authenticator to create (e.g. AppCustomAuthenticator): LoginAuthenticator
 Choose a name for the controller class (e.g. SecurityController) [SecurityController]:
 Do you want to generate a '/logout' URL? (yes/no) [yes]:

 Next:
 - Customize your new authenticator.
 - Finish the redirect "TODO" in the App\Security\LoginAuthenticator::onAuthenticationSuccess() method.
 - Check the user's password in App\Security\LoginAuthenticator::checkCredentials().
 - Review & adapt the login template: templates/security/login.html.twig.


* php bin/console user:create



RESSOURCES
https://symfony.com/doc/current/doctrine.html#configuring-the-database
https://symfony.com/doc/5.4/page_creation.html
https://symfony.com/doc/5.4/index.html
https://symfony.com/doc/current/setup/symfony_server.html
