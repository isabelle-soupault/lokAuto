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



>  ### Actions a réaliser
> -  refaire le merise
> -  enregistrer le merise dans le dossier lamanu/LOKAUTO
> -  faire le mokup
> -  faire le zooning
> -  configurer l'envoie de mail (https://www.copier-coller.com/envoyer-des-mails-en-local-avec-wamp/)
 
>