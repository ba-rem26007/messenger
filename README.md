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








Ressources
https://symfony.com/doc/current/doctrine.html#configuring-the-database
https://symfony.com/doc/5.4/page_creation.html
https://symfony.com/doc/5.4/index.html
https://symfony.com/doc/current/setup/symfony_server.html
