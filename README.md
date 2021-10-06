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
