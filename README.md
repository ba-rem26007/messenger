#prerequis: symfony https://symfony.com/download

#creation du projet 
create project : symfony new -webapp "symfony-start"

#composer v2 :
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
php bin/console make:entity
php bin/console make:controller


-----
BDD :
* php bin/console make:migration
* php bin/console doctrine:migration:migrate

-----
LISTE DES MESSAGES
* php bin/console doctrine:query:sql 'SELECT * FROM message'

-----
COMMANDE : pour créer un user
* php bin/console make:command

-----

USERS et SECURITE
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


