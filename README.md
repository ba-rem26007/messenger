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


BDD :

php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migration:migrate

OBJETS :





Ressources
https://symfony.com/doc/current/doctrine.html#configuring-the-database
https://symfony.com/doc/5.4/page_creation.html
https://symfony.com/doc/5.4/index.html
https://symfony.com/doc/current/setup/symfony_server.html
