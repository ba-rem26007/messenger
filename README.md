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

-----

VERIF : 
php bin/console list
php bin/console doctrine:migration:status

-----


CREATION DES ENTITES :

 Class name of the entity to create or update (e.g. BravePuppy):
 > Message  

 created: src/Entity/Message.php
 created: src/Repository/MessageRepository.php
 

php bin/console make:controller


-----

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


* php bin/console make:user
* php bin/console make:entity

* php bin/console make:migration
* php bin/console doctrine:migration:migrate

* php bin/console make:auth

----
on cree une commande : 

* php bin/console user:create


Ajout d'une API : 
* composer require api-platform/core

Ajout des services : config\services.yaml
* composer require symfony/slack-notifier
utilisation de la clef dans le .env


RESSOURCES
https://symfony.com/doc/current/doctrine.html#configuring-the-database
https://symfony.com/doc/5.4/page_creation.html
https://symfony.com/doc/5.4/index.html
https://symfony.com/doc/current/setup/symfony_server.html
https://symfony.com/doc/current/security.html


