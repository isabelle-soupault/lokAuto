# Projet location de voitures


***
Ici se trouve la **"feuille de route"** de ce projet.
Il y a donc le déroulé de l'installation des différents éléments, les tatonnements rencontrés, les actions à mener et autre.
Je recoimmande quand même de lire un peu tout même si c'est un gros pavé car parfois je reviens en arrière (feuille de route oibligé)

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

### Entités manquantes :
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

***

## Création du formulaire de connexion / Identification.

On utilise là le tuto de [Mamadou](https://www.kaherecode.com/tutorial/creer-un-blog-avec-symfony-4-authentification-et-autorisation-2)


        php bin/console make:auth


On a sélectionné 1 pour le form, on a utilisé les noms proposés et conservé le Authenticator comme proposé.

En allant sur [login](http://localhost:8000/login) on peut se connecter, sauf qu'il y a un problème de redirection.

On rajoute donc la partie 

        return new RedirectResponse($this->urlGenerator->generate('homepage'));

Dans la fonction 

        public function onAuthenticationSuccess


Ensuite, on va dans controller -> SecurityController et ajqsouter 
 
        /**
            * @Route("/home", name="home")
            */
            public function index(): Response
            {
                return $this->render('base.html.twig');
            }

Cela va nous permettre temporairement de se connecter. Cela sera changé plus tard quand on aurra notre page index. A ce moment là, on changera la route depuis le bon controller.

**REMARQUE** : il est possible d'activer le "se souvenir de soit", en décommentant la div suivante située dans template -> security -> login 


             <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="_remember_me"> Remember me
            </label>
        </div>


A ce stade, on peut vérifier que 
  - la page register fonctionne bien - la redirection ne fonctionne pas - ce sera vu plus tard.
  - la pager login fonctionne - la redirection vers home fonctionne.  


***

## Création de l'espace admin

Maintenant dans le fichier config -> routes.yaml

On 
 - déinsdexe les 3 premières lignes
 - modifie le path
 - remplace index par home

Ensuite, pour l'espace admin on rajoute dans ce même fichier


        admin:
        path: /admin
        controller: App\Controller\DefaultController::admin


Au final ce fichier est donc composé des lignes suivantes :

        home:
    path: /home
    controller: App\Controller\DefaultController::index

        admin:
    path: /admin
    controller: App\Controller\DefaultController::admin


Maintenant, comme on a définit un controller par défaut, il faut le créer manuellement dans src -> controller et je le nomme DefaultController pour respecter ce qui a été indiqué dans  mon routes.yaml

Dedans, je mets les informations suivantes :

        <?php

        namespace App\Controller;

        use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
        use Symfony\Component\HttpFoundation\Response;
        use Symfony\Component\Routing\Annotation\Route;


        class DefaultController extends AbstractController {
        /**
        * @Route("/home", name="home")
            */
            public function index(): Response
            {
                return $this->render('home.html.twig');
            }

        }


A QUOI SERT CE CONTROLLER ? A VOIR PLUS TARD !!!


**REMARQUE** Dès qu'on touche à un fichier de ENTITY on doit **OBLIGATOIREMENT** faire les deux commandes de migrations (migrate:migration)

On doit également ajouter dans le Default controller

        use App\Entity\User;

Ensuite, dans la fonction, on ajoute

            public function admin()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findBy(
            [],
            ['lastUpdateDate' => 'DESC']
        );

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin.html.twig', [
            //'car' => $car,
            'users' => $users
        ]);
    }

De là on créé un nouveau fichier dans template nommé admin.html.twig. C'est ici qu'on aura une overview accessible qu'aux admins.
On a copié ensuite le code de Mamadou en remplaçant content par body et en commentant toute la div articles car elle nous servira plus tard pour la gestion des voitures.

Au niveau visuel, on a maintenant une page avec le contenu de la BDD. Néanmoins, elle est limité dans les informations affichées, donc il faut faire le complément d'informations.

Donc on complête et une fois le tableau pas trop mal on continue.
L'aspect esthétique viendra plus tard.


***

## Interdire l'accès à l'administration

D'abord, on va devoir créer les roles d'accès.

Dans le security -> yaml et dans access_control: tout en bas, on décommente 


       - { path: ^/admin, roles: ROLE_ADMIN }

En rechargeant la page précédente [admin](http://localhost:8000/admin) on a un access denied qui pop si on est connecté.
Si on n'est pas connecté, cela renvoit vers le login.

Pour le moment, quand on se connecte on est tous des **users** et non des admins.

Maintenant il faut ajouter un role adminsitrateur.

On va donc dans src/Entity/User.php on rajoute tout en bas


            public function addRoles(string $roles): self
    {
        if (!in_array($roles, $this->roles)) {
            $this->roles[] = $roles;
        }

        return $this;
    }

Et dans le terminal on entre

        php bin/console make:command

Pour le nom, on lui donne app:user:promote

Cela va ajouter un nouveau dossier dans src -> command -> UserPormoteCommand
on remplace par les données de Mamadou

Avec la fonction 

        $ php bin/console app:user:promote email@email.com ROLE_ADMIN



Cela permet de transformer un compte en ADMIN en lui rajoutant le role qui va bien. sachant que par défaut, le role est USER

Maintenant que notre admin a accès à son domaine d'aministration, on doit vérouiller l'accès au controller.
Pour cela, il suffit de rajouter dans src\Controller\DefaultController.php

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

***

## Création des CRUD 
**RAPPEL** la commande à utiliser est 

        php bin/console make:crud


En nom on va utiliser 
  - User
  - Car

Et on va utiliser les noms proposés pour les controllers


On en profite pour faire une petite modification dans admin.html/twig où on va remplacer


        <td>{{ user.isVerified }}</td>
        par
        <td>{{ user.isVerified ? 'Yes' : 'No' }}</td>


Cela nous permet d'avoir une homogénéité d'informations entre la page user et la page admin (qui n'affichait pas le isVerified)


Maintenant, on va rajouter quelques contraintes dans src/controller/ CarController et UserController.
En annotations on ajoute simplement 

        @IsGranted("ROLE_ADMIN")

Cela va permettre de dire que l'action concernée n'est possible que si on est admin.
Par exemple, créer un nouvel utilisateur, c'est tout le monde (sinon on n'a pas de nouvel utilisateur) Mais éditer une voiture c'est l'admin.


Après quelques tests, IsGranted s'avère n'être possible que pour Symfony6 hors on est en LTS (version 5) De ce fait, cela ne fonctionne pas.

#IsGranted est à revoir plus **TARD** !

***

## Un peu de front !!

On va créer un beau dashboard pour l'admin. :) - Merci Gab \o/

On commence par installer le [composer](https://symfony.com/doc/current/bundles/EasyAdminBundle/index.html) nécessaire :

        composer require easycorp/easyadmin-bundle


        
Puis on créé le [dashboard](https://symfony.com/doc/current/bundles/EasyAdminBundle/dashboards.html) avec la commande 

        symfony console make:admin:dashboard

    

Sauf que maintenant tout est cassé ! Mais ce n'est pas grave.
Déjà, dans routes.yaml, on retire la partie admin.
Ensuite, si cela le demande, on **clear cache** avec la commande 

        php bin/console cache:clear

Et un beau dashboard apparaît !       

On va améliorer encore un peu le chemin !

On retourne dans routes.yaml et on y change la seconde partie par

        admin:
            path: /admin
            controller: App\Controller\Admin\DashboardController::index


### Ajout des CRUD pour le dashboard

        symfony console make:admin:crud

Et choisir Car et User et laisser par défaut les propositions.

Maintenant, on rajoute le code suivant dans \src\Controller\Admin\DashboardController.php :

                yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);

        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Liste', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Ajout', 'fas fa-user-plus', User::class)->setAction('new');
        //yield MenuItem::section('Locations');
        //yield MenuItem::linkToCrud('Liste', 'fas fa-car', Rental::class);
        //yield MenuItem::linkToCrud('Ajout', 'fas fa-user-plus', Rental::class)->setAction('new');
        yield MenuItem::section('Voitures');
        yield MenuItem::linkToCrud('Liste', 'fas fa-car', Car::class);
        yield MenuItem::linkToCrud('Ajout', 'fas fa-user-plus', Car::class)->setAction('new');
        yield MenuItem::section();
        yield MenuItem::linkToLogout('Déconnexion', 'fa fa-sign-out-alt');


Certaines parties sont commentées car on ne peut rien faire pour le moment.

### Customisation de Easyadmin
**ATTENTION** Cela partant dans tous les sens bien **TOUT** lire avant de suivre

On va se baser sur la vidéo de [Yoandev](https://www.youtube.com/watch?v=g6cYQ3IXGHY)

#### Titre en haut à gauche

src\Controller\Admin\DashboardController.php et dedans  aller en ligne 27 pour moi où il y a

        ->setTitle('LokAuto');


LokAuto peut être alors changé en ce que l'on veut.

On va dans DashbordController et 

    public function index(): Response
    {
        return parent::index();
        remplacé par  return $this->render('admin/dashbord.html.twig');
    }

Maintenant on créé un dossier admin dans templates et dedans on créé un fichoer dashboard.html.twig

En testant on a bien une page planche.

***ATTENTION** Si tous les dossiers de easyAdmin sont dans vendor il est **INTERDIT** de les modifier. C'est une librairie !!!!!


On va essayer de faire sur le dashboard un truc plus sympa avec des cards

#### Traductions

En utilisant la commande

        php bin/console translation:update --force fr --format yaml


On a des traductions automatiquement générées. On peut voir tout ce qui a été traduit en allant dans translations.
**ATTENTION** dans les fichiers on a par exemple : d'authentification en d''authentification

Ensuite, dans le fichier translations on créé un fichier nommé messages.fr.yaml

Et là on traduit les différents éléments.
Par exemple :

        Dashbord : Tableau de bord


Cela permet d'obtenir une traduction easywin 👍

***
  ### Remplacer l'adresse email par le nom et prénom

Dans src\Entity\User.php

     public function getFullname(): ?string
    {
        return $this->firstname . ' ' . $this->lastname;
    }


Puis dans src\Controller\Admin\DashboardController.php

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
        ->setName($user->getFullname());
    }


Cela remplacera l'adresse email à droite par le nom et prénom

***

## Créer les CRUD pour l'admin manquants 

        symfony console make:admin:crud

- fleet
- mark
- rental
- seat
- type

Et dans src\Controller\Admin\DashboardController.php
Puis on décommente les lignes commentées (47 -48 -49)


Ensuite, on rajoute dans les YIELD les lignes necessaires (copier coller des autres en modifiant les classes.) Ne **PAS** oublier en entête de rajouter use App\Entity\Fleet; etc pour que cela fonctionne. Sinon cela va donner une erreur.

### Customisation de la navBar

Un peu de travail bootstrap pour rendre joli.

Ensuite, on veut donner les instructions suivantes :

  - Si je ne suis pas connecté, je veux le bouton de coqnnexion
  - Si je suis connecté, je peux voir Mon profil et le bouton Déconnexion
  - Si je suis connecté ET que je suis un admin, je veux le bouton Dashboard.

Cela va se traduire par :


        <li class="nav-item">
            {% if app.user %}
                {% if app.user and 'ROLE_ADMIN' in app.user.roles %}
                    <li class="nav-item">
                        <a class="nav-link link-info" href="{{ path('admin') }}">Tableau de bord</a>
                    </li>
                {% endif %}
                    <li class="nav-item"> <a class="nav-link link-info" href="{{ path('user_show', {id:app.user.id}) }}">Mon profil</a></li>
                    <li><a class="nav-link link-info" href="/logout">Déconnexion</a></li>
                {% else %}
                    <li><a class="nav-link link-info"href="/login">Connexion</a></li>
                {% endif %}
        </li> 

---

### Modification de la route d'accès 

Dans config/routes.yalm on remplace /home par /

---

### Ajout de boutons de controles dans le Dashboard

Dans le src\Controller\Admin\DashboardController.php
on a rajouté 

        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Accueil', 'fa fa-home','/' );
        yield MenuItem::linkToLogout('Déconnexion', 'fa fa-sign-out-alt');

Ici le bouton déconnexion a été remonté en haut mais c'est un choix personnel.

***
### Page d'édition pour l'utilisateur

 - 1 - Dans templates\user\_form.html.twig mise en commentaire de la ligne 

        <button class="btn">{{ button_label|default('Sauvegarder') }}</button>

- 2 - Dans edit.html.twig on commente la ligne suivante pour interdire la suppression du profil par l'utilisateur

        {#{{ include('user/_delete_form.html.twig') }}#}

- 3 - Dans src\Form\RegistrationFormType.php, et plus précisément dans la  public function configureOptions(OptionsResolver $resolver), on rajoute
        
        'button_label' =>''

***

### Ajout du lien de création de compte dans la navbar

Ici pas grand chose à rajouter, c'est un simple copier/coller et un changement de direction / nom


***

### Préparation du dashboard pour l'affichage.

Dans un premier temps, bien s'assurer que le extend est

        {% extends '@EasyAdmin/page/content.html.twig' %}

Ensuite, pour mettre le titre, ce sera comme d'habitude dans 

        {% block page_title 'Hello' %}

De là, il faut bien veiller à mettre 

        {% block page_content %}

En effet, le dashboard est particulier dans le sens où il est composé de deux parties (visibles plus clairement sur la page utilisateurs par exemples)
 - une petite partie de quelques pixels
 - une grande partie.

La où ça peut coincer. Il est possible de créer les deux blocks
  - page_content
  - content
  

En considérant la particularité de la structure de ce dashboard, Si on se place en **content**
et qu'on met une div en row, alors cela va se placer **DANS** la petite bande.
Donc même si on fait des cartes alignées, elles vont être l'une en dessous de l'autre et sur une petite largeur. Ce que l'on n'a pas si on ne met qu'une seule et unique div.

Pour pouvoir aller dans la grande partie, on va mettre page_content.

et dedans on peut mettre les cards que l'on souhaite.



### Actions a réaliser
> -  refaire le merise
> -  enregistrer le merise dans le dossier lamanu/LOKAUTO
> -  faire le mokup
> -  faire le zooning
> -  configurer l'envoie de mail (https://www.copier-coller.com/envoyer-des-mails-en-local-avec-wamp/)
> - sur le dashboard faire en sorte que dès que'on va dans un lien l'url ne soit pas crappy
> - créer un user depuis le dashboard ne hash pas le PW
> - partie utilisateur a créer
> - dashboard - changer les icones
> - dashboard - FAIRE LE BILAN DE CE QUON DOIT FAIRE
> - organiser les dossiers
> - redirections à faire
> - ajouter une barre  de navigation dans le dashboard
> - Page Edit - cassé
> 
> 