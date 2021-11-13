# Handichiens
Repository de projet de travail CEFIM

## Prérequis

> **Php version >=7.4**
>
> **Symfony >=5.3**

## Dépendances

> **Symfony** :
> Webpack-encore,
> calendar-bundle
>
> **npm** :
> sass,
> bootstrap 5,
> fullcalendar 4

## Installation

>1. Cloner le dépôt.
>1. Exécuter la commande `composer install` suivante dans le répertoire du projet.
>1. Exécuter la commande `npm install` dans le répertoire du projet.
>1. Effectuer un `npm run dev` pour générer les fichiers .js et .scss.
>1. Créer un fichier **.env.local** et ajoutez la configuration de la base de données pour ce projet.
>1. Exécutez la commande `symfony console doctrine:database:create` pour créer la base de données depuis la configuration du **.env.local.**
>1. Effectuez les migrations avec la commande `symfony console doctrine:migrations:migrate`.
>1. Vous pouvez maintenant lancer `symfony serve`.

## Utilisation

### Pour les familles relais : 

>#### **Création de compte pour utilisateurs**

Sur la page inscription, saisissez un nom, prénom, adresse mail et mot de passe.
>Le mot de passe doit contenir au moins 8 caractères, dont  une minuscule, une majuscule, un chiffre et un caractère spécial.

Vous pouvez également saisir votre adresse et numéro de téléphone, ainsi que définir une photo de profil. (formats acceptés : `.jpg`, `.png`).

Une fois le compte créé, vous pouvez vous inscrire sur la page de connexion avec votre adresse mail et mot de passe.

>#### Compte utilisateur
Une fois connecté, vous serez redirigé sur la page `Dashboard`, qui regroupe vos disponibilités enregistrées et précise si un chien vous a été confié pour les dates indiquées.
En appuyant sur le bouton `Mon Compte`, vous pouvez voir vos informations de contact et les modifier.

>#### Planning
Pour ajouter vos disponibilités, appuyez sur le bouton `Planning`, puis sur `Ajouter disponibilité`.
Il vous sera demandé de saisir le début et la fin de votre période de disponibilité.
Une fois celle-ci enregistrée, elle apparaitra sur le calendrier de planning, ainsi que sur la page `Dashboard`.

### Pour les éducateurs :

Les éducateurs ont accès à des options supplémentaires :
* Consultation des chiens placés en famille d'accueil et ceux en attente de placement.
* Consultation de l'ensemble des profils des familles d'accueils et de leurs disponibilités.
* Modification des coordonnées des familles d'accueil et ajout de caractéristiques.
* Affecter un chien à une famille d'accueil durant une disponibilité choisie.

>#### Ajout d'un nouvel éducateur

Pour ajouter un nouvel éducateur, connectez vous à l'application avec un compte administrateur ou un compte éducateur existant. Une fois connecté, vous aurez accès à l'option `Ajouter un éducateur`, qui vous permettra de créerun compte pour le nouvel éducateur.

>#### Ajout d'un chien

Sélectionnez 