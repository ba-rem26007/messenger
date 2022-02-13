# INSTALLATION

## Environnement
* powershell
* docker
* 

## API clask
* https://api.slack.com/apps
=> 	Access Token : xoxp tocken
exemple : xoxe.xoxp-1-XXXXXXXXXXXXXXXXXXXXXXXXXXXX



### .env
copier le .env.exemple
mettre le token :

modifier le DATABASE_URL
LOCAL: "mysql://messenger:messenger@127.0.0.1:3306/messenger?serverVersion=mariadb-10.4.19"
DDEV : "mysql://db:db@db:3306/db?serverVersion=mariadb-10.3.31"


### ddev start
started symfony5
Project can be reached at https://symfony5.ddev.site https://127.0.0.1:51938


### Initialisation (and take a coffee)
* make sous windows https://sourceforge.net/projects/gnuwin32/
make install
ou (si vous n'avez pas make ...)
* ddev composer install
* ddev exec 'npm install'
* ddev exec 'yarn build'
* ddev exec 'php bin/console doctrine:migrations:migrate --no-interaction'

### user
un user existe deja : admin@fr.fr / pass : admin crée dans les migrations
sinon pour créer un user :
* ddev exec 'php bin/console user:create'



### ddev status
services
* MailHog (https):        https://symfony5.ddev.site:8026
* MailHog:                http://symfony5.ddev.site:8025
* phpMyAdmin (https):     https://symfony5.ddev.site:8037
* phpMyAdmin:             http://symfony5.ddev.site:8036



# DEBUG MESSENGER SYMFONY QUEUE
pour voir "The following messages can be dispatched"
* php bin/console debug:messenger


# cron pour envoyer les messages
* php bin/console messenger:consume async
* ~ ddev exec 'php bin/console messenger:consume async'
ou mode debug :
* php bin/console messenger:consume -vv




# Creation du projet pas à pas 

create project : symfony new -webapp "symfony-start"

## Composer v2 :
composer require symfony/webpack-encore-bundle
composer require symfony/doctrine-messenger
composer require symfony/browser-kit
composer require symfony/orm-pack
composer require symfony/maker-bundle --dev

Création de la base de données et du user
Modification du .env (.env.exemple pour s'inspirer)

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

ou
* php bin/console security:hash-password 
pour recupere le password salé
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

Ajout des composants pour une API : 
* composer require api-platform/core

Ajout des services : config\services.yaml
* composer require symfony/slack-notifier
utilisation de la clef dans le .env

-------

## RESSOURCE
### SYMFONY
* https://symfony.com/download
* https://symfony.com/doc/current/doctrine.html#configuring-the-database
* https://symfony.com/doc/5.4/page_creation.html
* https://symfony.com/doc/5.4/index.html
* https://symfony.com/doc/current/setup/symfony_server.html
* https://symfony.com/doc/current/security.html


###AUTRE


Notifier: https://symfony.com/doc/current/notifier.html
API: https://sylius.com/blog/api-for-a-modern-symfony-application/ (api platform et FOSRestBundle)


### DDEV : 
* https://ddev.com/


# Installation 

(j'ai volontairemnt pas mis de librairies locales pour yarn et encore pour le moment)
Il suffit de lancer le processus d'installation en tapant:

* test avec make install et *DDEV en cours*
* 
* composer install
* composer require encore // si un soucis avec le yarn build ci-dessous
* bin/console doctrine:migrations:migrate
* npm install
* yarn build


## API EN COURS 


## JWT via DDEV

```
curl --location --request POST 'http://symfony5.ddev.site/api/login' \
--header 'Content-Type: application/json' \
--data-raw '{
    "username":"admin",
    "password":"admin"
}'
```

## GET ALL MESSAGES via DDEV

```
curl --location --request GET 'https://symfony5.ddev.site/api/messages' \
--header 'Authorization: Bearer **TOKEN_JWT**'
```

## CREATE MESSAGE via DDEV

```
curl --location --request POST 'https://symfony5.ddev.site/api/messages' \
--header 'accept: application/ld+json' \
--header 'Content-Type: application/ld+json' \
--header 'Authorization: Bearer **TOKEN_JWT**' \
--data-raw '{
  "title": "essai",
  "body": "essai via curl",
  "status": false,
  "choice": "email",
  "emissionDate": "2022-01-17T18:31:47.170Z"
}'
```


## QUALITY CODE
# GrumpPHP (phpstan, phpmd)

https://github.com/sci3ma/symfony-grumphp

