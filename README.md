## Fonctionnalités

### Implémenté :
- Tous les cruds  
- Article :  
    - Recherche par mot-clé  
    - Upload d'image  
    - BBCode  
    - Ajax like/commenaire  
    - Ajax des mots clés, thématique et angle suivant la langue pour création/modification article  

- User et membre  
    - Connexion user et membre et hash du mot de passe  
    - Protection minimal du panel admin  
    - Session & cookies

### Pas implémenté:
- captcha
- BBcode commentaires
- Formulaire de contact 

## Panel Admin

- Accessible depuis : `/admin.php`
- https://plateforme-mmi.iut.u-bordeaux-montaigne.fr/etu-mmi-01/admin.php

## Panel front

- Accessible depuis : `/index.php` (si c'est bien la page d'accueil que vous attendez)
- https://plateforme-mmi.iut.u-bordeaux-montaigne.fr/etu-mmi-01/ 

**Identifiant localhost/serveur iut**

> super-admin :
> email : `admin@email.com`
> pseudo : `admin2003!`
> mdp : `adminDemo`

> membre :
> email : `jhondoe@email.com`
> pseudo : `jhondoe`
> mdp : `jhondoe2003!`

### Structure et règles de la Base de données

La base de données fournie :
=> la votre épurée et mise à jour

### Pour les utilisteurs/super-admin

Seul les user de niveau superviseur ou plus sont autorisés à accéder au panel admin (pour éviter l'accès à n'importe qui, controle des inscription)

### Pour les utilisateurs/membres

Rien à préciser

### Pour les articles

- Il nous semble que les photo de plus de 4mo ne sont pas uploadés à cause des limites POST apache du serveur de l'iut

### Pour les commentaires

Connexion requise (redirection si pas connecté)

### Pour les likes

Connexion requise (redirection si pas connecté)

### Pour les autres éléments petinents à nous préciser

##### Test en local
- Bien mettre la constante IN_PROD à `false` dans `/config/inProd.php`
- Les formulaires de login/register se remplissent automatiquement

##### Pas de bannière de consentement aux cookies
Car les seuls cookies présents sont nécessaires, et créés lors d'une connexion. Ce sont des cookies de session, obligatoirement acceptés depuis les cgu, lors de la création du compte.

##### Ajout de fonctions utilitaires à l'achitecture de base
- `/util/validator.php` : Validation des champs de la requêtes

##### Dossiers
- `/_RESSOURCE` : Fichier sql des bases de données et images pour l'aide à la conception du code.  
- `/admin` : Pages de login pour le panel admin  
- `/assets` : Dossiers contenant les assets et les uploads (js, css, imgs, uploads)  
- `/api` : Api pour l'ajax (récupération des mots clés, des likes, des commentaires, etc.)  
- `/back` : Les fichiers edit, delete, view etc  
- `/config` : Définition de constantes utiles (nous aurions pu mettre les paths Gwendal c'est vrai. Mais avec les fonctions on a pas eu à modifier quoi que ce soit lors de la mise en prod!)  
- `/layouts` : Layouts à inclure pour factoriser le code (back-office ou front-office)  
- `/middleware` : Scripts pour autoriser l'accès à une page, ou apporter une donnée (Gwendal : c'est presque du procédural, non? Ah si si je t'assure on aurait pu faire de l'objet là)

