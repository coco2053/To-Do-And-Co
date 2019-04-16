ToDoList
====

Projet 8 - Parcours développeur d'application PHP/Symfony - OpenClassrooms
--------------------------------------------------------------------------

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/5ff84602fbf24d5f9c81ff99ca1dbada)](https://www.codacy.com/app/coco2053/To-Do-And-Co?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=coco2053/To-Do-And-Co&amp;utm_campaign=Badge_Grade)
Bonjour, ceci est le projet qui m'a permit d'apprendre à améliorer la qualité d'une apllication Symfony existante.
Les documents preparatoires (diagrammes) se trouvent dans le repertoire "diagrams".

### Installation

1. Clonez ou telechargez le repository.
1. Modifiez le fichier .env avec vos parametres de BDD.
1. Ouvrez la console dans le repertoire racine.
1. composer install -> pour installer toutes les dependances.

1. Importez le fichier "todo.sql" dans votre BDD
puis
1. php bin/console server:run -> pour lancer le serveur local.
1. Vous pouvez entrer l'adresse "localhost:8000" dans votre navigateur et admirer le resultat.

### Tests

Pour lancer les tests unitaires :
1. Lancer la console à la racine du projet
1. Entrez vendor/bin/simple-phpunit

Pour lancer les tests fonctionels :
1. Entrez l'adresse de votre serveur Selenium dans le fichier behat.yml.dist
1. Lancer la console à la racine du projet
1. Entrez vendor/bin/behat

### Pour contribuer

Consultez [CONTRIBUTING.md](https://github.com/coco2053/To-Do-And-Co/blob/master/CONTRIBUTING.md)

### Built with :

- symfony 3.4
- behat 3.5
- symfony/phpunit-bridge 3
- behat/symfony2-extension 2.1
- behat/mink 1.7

 À bientôt ...


