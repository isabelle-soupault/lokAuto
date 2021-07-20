# Projet location de voitures


***
Ici se trouve la **"feuille de route"** de ce projet.
Il y a donc le déroulé de l'installation des différents éléments, les tatonnements rencontrés, les actions à mener et autre.

***

  - Création du nouvel espace de travail :
       * Symfony new LokAuto 
            PUIS
       * on doit installer composer pour pouvoir utiliser les composers.

 Quand on installe avec Symfony new NomProjet sans le --version cela permet de mettre la dernière version.
Remarque : actuellement il y a un problème de versionning. L'installateur indique 
4.25.4 alors qu'en vrai on est en 5 (version lts). Le problème est donc lié à des informations différentes entre l'installeur et la réalité.
 
 Pour l'initialiser, 
 
- composer init
- composer require twig
- composer require annotations
- composer require asset
- composer require translation
- composer require profiler --dev

Ensuite on vérifie si Doctrine est ou non installé v(voir dans la doc) et on va à installing Doctrine depuis le site de la doc (https://symfony.com/doc/current/doctrine.html#installing-doctrine)

Pour info c'est
 - composer require symfony/orm-pack
 - composer require --dev symfony/maker-bundle

***

## Création des entités
Pour cela on va ici créer un user avec php bin/console make:user
mais il est possible qu'il faille ajouter le module composer require security


### Entity User
Cette entité est effectuée en 2 étapes :
 - php bin/console make:user
  en mettant
     * User (par défaut)
     * via doctrine Yes
     * email
     *  hash user pw NO
  
 - php bin/console make:entity
  en mettant User. Cela va dire que l'entité existe déjà et on qu'on peut ajouter les classes manquantes
    * firstname string 50
    * lastname string 50
    * phone string 14
    * birthDate date


Ensuite, on créé une nouvelle entity avec php bin/console make:entity

### Entity : Rental

- startDate
- endDate
- users relation  User ManyToOne non vide

### Création des entités :
 - Seat smallint
 - Fleet string 50
 - Mark string 50
 - Type string 50

Ici il était important de créer les "petites entitées car elles seront toutes appellées dans l'entité Car. SI on ne l'avait pas fait, on n'aurait pas pu créer directement les wrelation et donc on aurait du naviguer entre les différentes tables.

### Entité Car

Composée de
- price
- availability
- registration

Et on ajoute les relations :
 - types relationType ManyToOne
 - seats relation Seat ManyToOne
 - rentals relation Rental ManyToOne
 - fleets relation Fleet ManyToOne

***

## Création de la base de données

Après avoir lancé wamp on créé la bdd:

 - On doit créer un fichier .env.local
 - Dedans, on va copier - coller le contenu de .env
 - On commente la ligne 27
 - On décommente la ligne 26 et on la modifie en 
        DATABASE_URL="mysql://root@127.0.0.1:3306/LokAuto"
        root correspond a notre bdd par défaut, et LokAuto, le nom de la BDD qu'on veut.

 - Dans le terminal on tape :
        php bin/console doctrine:database:create

Pour finir, on peut vérifier dans PhPmyAdmin que la BDD a été créée.

***

## Migration

Cela permet de conserver un historique  de la BDD dans le dossier migrations

  Dans le terminale  saisir 
   - php bin/console make:migration
   - php bin/console doctrine:migrations:migrate et Yes

migration correspond au push  

migrate correspond au pull

***

## Authentification et autorisations


Anonymous true empêche le visiteur de visualiser le site - cela exige à ce dernier de se connecter pour y accéder.
**Remarque :** depuis la version 5.1 il n'est plus possible d'utiliser anonymous qui a été deprecated. La seule solution est d'utiliser :

        lazy:true



***

## Création d'un formulaire de connexion

Ajouter le composer
composer require form validator

Puis, appeller 
        php bin/console make:registration-form
A la première question on dit non
et à la seconde (envoyer un email pour confirmer) on répond oui


Ensuite on installe le package manquant

- composer require symfonycasts/verify-email-bundle symfony/mailer

Dans .env.local, copier les 3 dernières lignes et décommenter celle du milieu !


            ###> symfony/mailer ###

            MAILER_DSN=smtp://localhost

            ###< symfony/mailer ###


Maintenant on a bien un formulaire en allant sur [localhoost8000](http://localhost:8000/register) on a bien un début de formulaire.
Mais il n'est pas encore possible de rentrer l'utilisateur dans la BDD car en déclarant nos entitées on a indiqué que cela ne pouvait pas être null.

Il nous manque donc les champs suivants :
  - phone
  - firstname
  - lastname


Dans register on peut retirer l'ensemble des form_row car on a déjà tout créé dans le form



Dans le blockstylesheet de template -> base on rajoute :
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

Cela va permettre d'avoir bootstrap d'installé.

Dans l'état actuel des choses, il est bien possible de faire des rentrées dans la BDD.

Cependant, des erreurs apparaissent :
- problème d'envoie de l'email
- mauvaise redirection.

Il est donc nécessaire, dans un premier temps de configurer son localhoost et son Wamp pour envoyer des emails.



## Création des CRUD



>  ### Actions a réaliser
> -  refaire le merise
> -  enregistrer le merise dans le dossier lamanu/LOKAUTO
> -  faire le mokup
> -  faire le zooning
 
>