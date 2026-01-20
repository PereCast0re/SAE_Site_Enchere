# BidStars



## Présentation



### Projet



Ce travail est le résultat d'un projet étudiant au sein du BUT Informatique de Nevers.

Durant cette SAE et pendant un semestre, nous devions développer une application s'appuyant sur une base de donnée tout en expérimentant une démarche incrémentale.



### Documents



Dans ce projet vous y trouverez le code source mais aussi tous les rendus que nous avons pu faire durant ce projet dans le dossier `Documents`.



### Notion



Pour plus d'informations, veuillez trouver ci-joint le [notion du projet](https://arthur-eudeline.notion.site/SA-03-01-D-veloppement-d-une-application-10ca285a488480d1a474e226b40728ea).



### Procédures



Il est possible que si vous ajoutez des images trop volumineuses, qu'une erreur s'affiche.

Il est aussi possible que si vous créer un compte et que vous souhaitez recevoir les mails, que vous n'ayez pas tous les paramètres nécessaires pour les recevoir.



Veuillez donc trouver toutes les procédures dans `Documents\Procedure`.



## But de l'application



BidStars est un site d'enchères centré uniquement sur les objets appartenant ou ayant appartenu aux célébrités.



Dans ce site vous pouvez :

* créer un compte
* créer une annonce (description, image, certificat d'authenticité)
* enchérir
* visualiser les annonces et les rechercher
* mettre en favoris
* modifier votre compte
* visualiser son historique des annonces
* consulter l'évolution du prix et du nombre de vue d'une annonce publiée



## Membres (3)



* Thomas BARTHOUX-SAUZE → [PereCast0re](https://github.com/PereCast0re)
* Kyllian RIVIERE → [Kyno3146](https://github.com/Kyno3146)
* Jimmy GARNIER → [JimmyGAR](https://github.com/JimmyGAR)



## Lancement de l'application



Pour utiliser notre application, vous devez avoir installé au préalable [WamppServer](https://www.wampserver.com/).



Lancer WampServer.



### Initialisation



Télécharger le dossier du projet (Bouton vert `<> Code` → `Download ZIP`).



#### Méthode 1 (invite de commande)



##### Étape 1



Rendez-vous dans les fichiers de l'application WampServer.



Suivant l'arborescence de l'explorateur du fichier, rendez-vous dans **bin** (C:\\wamp64\\bin\\mysql\\mysql9.1.0\\bin)



##### Étape 2



Exécutez le fichier mysqld.exe en tant qu'administrateur. (Clic droit sur l'exécutable mysqld.exe → Exécuter en tant qu'administrateur)



Ouvrez l'invite de commande en faisant un clic droit sur un espace vide du fichier.



Tappez 

```

.\mysql.exe -u root -p

```



Entrez votre mot de passe (si vous venez de l'installer, le mot de passe est vide, donc appuyez sur entrée de votre touche clavier)



Vous avez désormais accès à la base de donnée.



##### Étape 3



Copier le fichier `BDD_constructor.sql` de ce projet situé à la racine du projet.



Coller le dans le dossier où vous avez ouvert l'`invite de commande` (`C:\wamp64\bin\mysql\mysql9.1.0\bin`)



Pour initialiser la database, tappez 

```

SOURCE BDD_constructor.sql;

```



#### Méthode 2 (PhpMyAdmin)



##### Étape 1



Ouvrez votre navigateur et rendez vous à l'adresse suivante : ```http://localhost/phpmyadmin/``` ou [cliquez ici](http://localhost/phpmyadmin/)



##### Étape 2



Entrez votre nom d'utilisateur et votre mot de passe (si vous venez d'installer Wamp, faites directement connexion)



##### Étape 3



Dans la barre situé en haut de l'écran de la page, vous devriez apercevoir `Importer`.



Cliquez dessus.



Ajouter le fichier `BDD_constructor.sql` de ce projet situé à la racine du projet.



Puis scrollez et cliquez sur le bouton `Importer`.



### Configuration



Après avoir suivi les étapes ci-dessus, vous pouvez désormais utiliser notre application mais il manque une dernière étape.



Rendez-vous dans le fichier www de WampServer (`C:\wamp64\www`).



Copier/coller tout le projet directement dans ce dossier.



Ouvrez votre navigateur et dirigez vous à l'adresse suivante : 

```

http://localhost/

```



Cliquez sur le nom de votre fichier (si vous n'avez pas créé de fichiers, le nom sera `SAE_Site_Enchere`)



Puis cliquez sur `newMVC`.

### Scripts (moteur de recherche + recherche de célébrités)

A la racine du projet vous pouvez retrouver différents scripts.

#### Moteur de recherche

Lorsque que vous accéderez à notre site d'enchère, vous aurez la possibilité de rechercher une annonce.

Seulement pour que la recherche soit effective, il faut démarrer notre API.

Dans un premier temps il faut télécharger l'exécutable en fonction de votre système d'exploitation via le lien suivant :
[cliquez ici pour télécharger l'exécutable](https://github.com/meilisearch/meilisearch/releases)

Ensuite, il faut exécuter le fichier `meilisearch-windows-amd64.exe`.

Ouvrez l'invite de commande en faisant un clic droit dans le vide à la racine de ce projet.

Puis exécuter la requête suivante :
```
.\meilisearch-windows-amd64.exe --master-key CLE_TEST_SAE_SITE
```

#### Recherche de célébrités

Vous pouvez aussi rechercher des célébrités via le script python `ScriptCelebrity.py`.

Vous devez donc avoir [python](https://www.python.org/downloads/) d'installé sur votre machine.

Pour lancer la recherche il suffit d'ouvrir le terminal à la racine du projet.

Puis exécuter la commande suivante :
```
python .\ScriptCelebrity.py
```
OU en lançant le fichier sur un logiciel comme Visual Studio ou Thonny et l'exécuter via leur interface.

### Identifiant de connection

* Admin (permet d'accepter ou refuser des annonces publiées)

&nbsp;	email : `admin@gmail.com`

&nbsp;	mot de passe : `Admin1234!`

* Utilisateur de test (simple utilisateur ayant accès au site pour naviguer, enchérir et publier une annonce)

&nbsp;	email : `test@gmail.com`

 	mot de passe : `Test1234!`





Vous avez désormais accès à notre site d'enchère ! 

Libre à vous d'essayer toutes les fonctionnalités !

Merci pour le temps que vous consacrerez à regarder ce projet !







&nbsp;





