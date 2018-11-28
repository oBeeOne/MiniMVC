Application web < Phone >
NFA021 2014

*** Installation WAMP ***

1- Copier le dossier des fichiers dans votre répertoire 'wamp/www/'

1- Importer le script "createdb.sql" dans MySQL pour créer la base de données

2- Créer un nouvel utilisateur MySQL et attribuer les privilèges sur la base à l'utilisateur

3- Ouvrir le fichier 'application/config/config.ini' et changer les paramètres de connexion à la base

5- Ouvrir le fichier 'public/index.php' et modifier l'url de base 'BASE_URL'

4- Créer un virtual host dans apache avec la même BASE_URL et relancer apache

5- Lancer le site en tapant l'adresse de base

*** Accès ***

Login admin :
code = 999
mdp = Ph0n34dm1n

Login logistique :
code = 700
mdp = Ph0n3st0ck

Login vendeur :
code = 124
mdp = Ph0n3v3n73

*** Accès online ***

Le site sera disponible à l'adresse http://phone.digiarts-solutions.net pendant la durée de la correction à partir de la mise à jour des DNS.


*** Description ***

L'application est basée sur une architecture MVC légère connectée à une base de données MySQL via PDO.

Cette application est destinée à gérer un stock de téléphones mobiles.
Tous les mouvements de stock sont enregistrés dans la base avec l'utilisateur qui a effectué l'opération.
Un état des stocks est consultable pour suivre l'historique des mouvements avec différentes fonctions de tri automatique effectué via des requêtes ajax.

L'application possède 3 niveaux d'autorisation :
- admin
- logistique
- vendeur

Le niveau admin a accès à toutes les fonctions de l'application.
Le niveau logisitque a accès aux fonctions de gestion de stock.
Le niveau vendeur est limité à la consultation des états du stock.

L'autentification est gérée via un tableau stocké en session.
Un timer de 5 minutes détruit automatiquement la session à la prochaine requête http en cas de non utilisation pendant cette durée.

*** Structure de la base de données ***

La base de données contient 7 tables et 1 vue.
Le schema du MCD/MLD est disponible via le fichier 'phone.mwb'.
Pour le consulter, il faut l'ouvrir avec l'application MySQL Workbench.

*** TODO list ***

- Traiter l'élément de menu 'Config' qui permet au niveau "admin" de gérer les mots de passe utilisateurs ainsi que de modifier des données dans la base.
- Améliorer l'ergonomie ajoutant des requêtes ajax pour tous les formulaires.
- Implémenter un moteur de recherche via des requêtes préparées et ajax pour offrir une recherche plus intuitive.