# ⭐**BidStars**

## 💬**Présentation**

## ✅**Projet**

<div style="display: flex; justify-content: center;">
<img src="./newMVC/templates/Images/Logo.png" width="250">
</div>

Ce travail est le résultat d'un projet étudiant au sein du BUT Informatique de Nevers.

Durant cette SAE et pendant deux semestres, nous devions développer une application en s'appuyant sur une base de données tout en expérimentant une démarche incrémentale.

## 📋**Sommaire**

- [Présentation](#présentation)
    - [Projet](#projet)
    - [Documents](#documents)
    - [Notion](#notion)
    - [Procédures](#procédures)
- [But de l'application](#but-de-lapplication)
- [Membres (3)](#membres-3)
- [Lancement de l'application](#lancement-de-lapplication)
    - [Initialisation](#initialisation)
        - [Méthode 1 (PhpMyAdmin)](#méthode-1-phpmyadmin)
            - [Etape 1](#étape-1)
            - [Etape 2](#étape-2)
            - [Etape 3](#étape-3)
        - [Méthode 2 (Invite de commande)](#méthode-2-invite-de-commande)
            - [Etape 1](#étape-1-1)
            - [Etape 2](#étape-2-2)
            - [Etape 3](#étape-3-3)
    - [Configuration](#configuration)
    - [Scripts (moteur de recherche + recherche de célébrités)](#scripts-moteur-de-recherche--recherche-de-célébrités)
        - [Moteur de recherche](#moteur-de-recherche)
            - [Activer le moteur de recherche](#activer-le-moteur-de-recherche)
            - [Ajouter les annonces dans le moteur de recherche](#ajouter-les-annonces-dans-le-moteur-de-recherche)
        - [Recherche de célébrités](#recherche-de-célébrités)
    - [Identifiant de connexion](#identifiants-de-connexion)
    - [Remerciements](#️remerciements)

## 📂**Documents**

Dans ce projet vous y trouverez le code source de notre application disponible à l'adresse suivante : SAE_SITE_ENCHERE/newMVC.
Mais aussi tous les rendus que nous avons réalisé durant ce projet dans le dossier SAE_SITE_ENCHERE/Documents.

*Pour visualiser les documents et découvrir notre projet, il vous faudra suivre la partie [Lancement de l'application](#lancement-de-lapplication).*

## 📍**Notion**

Pour plus d'informations, veuillez trouver ci-joint le [notion du projet](https://arthur-eudeline.notion.site/SA-03-01-D-veloppement-d-une-application-10ca285a488480d1a474e226b40728ea).

## 📝**Procédures**

Veuillez trouver toutes les procédures concernant le projet situé à l'adresse `SAE_SITE_ENCHERE/Documents/Procedure`.

La différence entre les étapes ci-dessous et les **procédures est que les procédures sont beaucoup plus détaillées et accessibles à tous**.
Tandis que les démarches à suivre dans ce README sont accessibles **seulement aux personnes ayant déjà de l'expérience avec WampServer** et dans le cas où les procédures seraient corrompues; si l'équipe de développement souhaiterait relancer le projet dans plusieurs années.

Vous y trouverez notamment des explications pour :
- Résoudre le problème d'images trop volumineuses
- Résoudre le problème concernant la réception des mails de notre application

*PS : Un rappel sera fait à chaque partie correspondante pour vous indiquer quelle procédure doit être utilisée.*

## ❓**But de l'application**

BidStars est un site d'enchères centré uniquement sur les objets appartenant ou ayant appartenu aux célébrités.
Similaire à Leboncoin, Ebay, Benzin, Catawiki, etc.

Dans ce site vous pouvez :

* créer un compte
* créer une annonce (avec description, image, certificat d'authenticité, titre, etc)
* enchérir (avec de l'argent virtuel)
* visualiser les annonces et les rechercher
* mettre en favoris
* modifier votre compte
* visualiser son historique des annonces
* consulter l'évolution du prix et du nombre de vue d'une annonce publiée
* panneau administrateur

## 🎓**Membres (3)**

* Thomas BARTHOUX-SAUZE → [PereCast0re](https://github.com/PereCast0re)
* Kyllian RIVIERE → [Kyno3146](https://github.com/Kyno3146)
* Jimmy GARNIER → [JimmyGAR](https://github.com/JimmyGAR)

## 📢**Lancement de l'application**

Pour utiliser notre application, vous devez avoir installé au préalable [WamppServer 3.3.7 - 64 bits ou version ultérieure](https://www.wampserver.com/) et tous les VC Redistribuables nécessaires (toutes les versions sont indiqués lors de l'installation de l'exécutable et vous demanderas d'installer ceux manquants via le lien suivant : [cliquez ici](https://wampserver.aviatechno.net/)).

Pour information, nous utilisons `Apache 2.4.62.1`, `PHP 8.3.14` et `MySQL 11.5.2`.

Pour plus d'informations ou d'aides, consultez notre procédure d'installation ci-dessous.

<div style="text-align: center; margin: 20px">
<a href="./Documents/Procedure/Procedure_Installation_WampServer.docx"><strong>Comment installer WampServer ? Cliquez ici</strong></a>
</div>

Si l'application est déjà installée,
<br>
**Lancer WampServer.**

## ✍️**Initialisation**

<div style="text-align: center; margin: 20px">
<a href=""><strong>Comment télécharger le projet ? Cliquez ici</strong></a>
</div>

Télécharger le dossier du projet (Bouton vert en haut de cette page `<> Code` → `Download ZIP`).

Depuis l'explorateur de fichiers, dézipper le projet dans le dossier `www` du logiciel WampServer situé à l'adresse suivante : `C:\wamp64\www`.

Ensuite vous avez 2 méthodes différentes ci-dessus qui s'offre à vous pour initialiser la base de données dans WampServer :
- [Méthode 1 (PhpMyAdmin)](#méthode-2-phpmyadmin) `SIMPLE`
- [Méthode 2 (Invite de commande)](#méthode-1-invite-de-commande) `EXPERTE`

## 🟢**Méthode 1 (PhpMyAdmin)**

<div style="text-align: center; margin: 20px">
<a href=""><strong>Comment initialiser la base de données en méthode simple (PhpMyAdmin) ? Cliquez ici</strong></a>
</div>

## 1️⃣Étape 1

Ouvrez votre navigateur et rendez vous à l'adresse web suivante : ```localhost/phpmyadmin/``` ou [cliquez ici](http://localhost/phpmyadmin/)

## 2️⃣Étape 2

Entrez l'identifiant et le mot de passe de connexion :

utilisateur : `root`
<br>
mot de passe : `    ` → le mot de passe est vide

Cliquez sur le bouton `Connexion`

## 3️⃣Étape 3

Dans la barre situé en haut de l'écran de cette page, vous devriez apercevoir un espace nommé `Importer`

Cliquez dessus.

Sélectionner le fichier SQL `SAE_SITE_ENCHERE/BDD_constructor.sql`.
<br>
Si vous avez suivi toutes les étapes pérécentes il doit se situer à l'emplacement suivant : `C:\wamp64\www\SAE_SITE_ENCHERE\BDD_constructor.sql`

Puis défiler en bas de la page et cliquez sur le bouton `Importer`.

*La base de données est maintenant initialisé sur WampServer.*

## ⚫**Méthode 2 (Invite de commande)**

<div style="text-align: center; margin: 20px">
<a href=""><strong>Comment initialiser la base de données en méthode experte (Invite de commande) ? Cliquez ici</strong></a>
</div>

## 1️⃣Étape 1

Rendez-vous de nouveau dans le dossier du logiciel WampServer situé à l'adresse suivante : `C:\wamp64`.

Ensuite, rendez-vous dans **bin** en suivant l'arborescence de fichier suivant : `C:\wamp64\bin\mysql\mysql9.1.0\bin`

## 2️⃣Étape 2

Exécutez le fichier mysqld.exe en tant qu'administrateur. (Clic droit sur l'exécutable mysqld.exe → Exécuter en tant qu'administrateur)

Ouvrez l'invite de commande à partir de ce fichier comme si vous vouliez créer un nouveau dossier ou fichier. (Clic droit sur un espace vide dans le dossier → "Ouvrir dans le terminal")

Entrez :

```

.\mysql.exe -u root -p

```

Appuyez une première fois sur la touche de votre clavier `Entrée` pour exécuter la commande ci-dessus.
<br>
Puis une seconde fois sur cette même touche pour valider le mot de passe qui va vous être demandé, mais qui est vide.

Vous avez désormais accès à la base de donnée de WampServer.

## 3️⃣Étape 3

Copiez le fichier `BDD_constructor.sql` de ce projet situé à la racine du projet nommé SAE_SITE_ENCHERE (C:\wamp64\www\SAE_Site_Enchere)

Collez le dans le dossier **bin** où vous avez ouvert l'`invite de commande` (`C:\wamp64\bin\mysql\mysql9.1.0\bin`)

Pour initialiser la database, entrez :
```

SOURCE BDD_constructor.sql;

```
Puis exécuter la commande en appuyant sur la touche de votre clavier `Entrée`.

*La base de données est maintenant initialisé sur WampServer.*

## ⚙️**Configuration**

Après avoir suivi les étapes ci-dessus, il vous reste une dernière étape à réaliser pour utiliser notre application.

Ouvrez votre navigateur et dirigez vous à l'adresse web suivante : `http://localhost/SAE_SITE_ENCHERE/newMVC` ou [cliquez ici](http://localhost/SAE_SITE_ENCHERE/newMVC)

## 🧩**Scripts (moteur de recherche + recherche de célébrités)**

Dans ce projet vous pouvez aussi retrouver différents scripts.

## 🔎**Moteur de recherche**

## Activer le moteur de recherche

Lorsque que vous accéderez à notre site d'enchère, vous aurez la possibilité de rechercher une annonce depuis le menu (header) qui se trouve en haut de votre écran.

Seulement, pour que la recherche soit effective, il faut démarrer l'**API***.

**API** : Service web mettant à disposition des fonctionnalités réutilisables par d'autres logiciels.

<div style="text-align: center; margin: 20px">
<a href=""><strong>Comment activer le moteur de recherche ? Cliquez ici</strong></a>
</div>

Dans un premier temps, il faut télécharger l'exécutable`meilisearch 1.28.0` en fonction de votre système d'exploitation (Windows/Linux) via le lien suivant : https://github.com/meilisearch/meilisearch/releases ou [cliquez ici](https://github.com/meilisearch/meilisearch/releases)

Téléchargez l'exécutable dans votre dossier téléchargement de votre ordinateur.

Ensuite, il faut exécuter le fichier `meilisearch-windows-amd64.exe`.

Ouvrez l'invite de commande à partir de ce fichier comme si vous vouliez créer un nouveau dossier ou fichier. (Clic droit sur un espace vide dans le dossier → "Ouvrir dans le terminal")

Puis exécuter la requête suivante :
```
.\meilisearch-windows-amd64.exe --master-key CLE_TEST_SAE_SITE
```

Puis exécuter la commande en appuyant sur la touche de votre clavier `Entrée`.

Vous pouvez à présent utiliser le moteur de recherche sur notre application.
Pour l'utiliser, cliquez sur le lien situé en haut de notre application nommé "Acheter" pour accéder à la page, non accessible sans avoir lancé l'invite de commande.

**IMPORTANT** : il faut que le terminal soit ouvert en arrière plan sinon le moteur de recherche ne fonctionnera pas. 

## Ajouter les annonces dans le moteur de recherche

Pour ajouter les nouvelles annonces dans le moteur de recherche, il faut exécuter le fichier `import-encheres.php`, simplement en accédant au lien suivant `http://localhost/SAE_SITE_ENCHERE/newMvc/src/controllers/import-encheres.php` ou [cliquez ici](http://localhost/SAE_SITE_ENCHERE/newMvc/src/controllers/import-encheres.php)

**IMPORTANT** : il vous faut avoir lancer le moteur de recherche en arrière plan avant d'ajouter vos annonces en suivant les étapes décrites ci-dessus, [cliquez ici](#activer-le-moteur-de-recherche) pour y accéder.

## ✨**Recherche de célébrités**

Vous pouvez aussi rechercher des célébrités via le script python `ScriptCelebrity.py`.

Vous devez donc avoir [python](https://www.python.org/downloads/) d'installé sur votre machine.

<div style="text-align: center; margin: 20px">
<a href=""><strong>Comment exécuter le script pour rechercher les célébrités ? (installation de python et aides supplémentaires) Cliquez ici</strong></a>
</div>

Pour lancer la recherche il suffit d'ouvrir le terminal à la racine du projet nommé SAE_SITE_ENCHERE (C:\wamp64\www\SAE_Site_Enchere).

Puis exécuter la commande suivante :
```
python .\ScriptCelebrity.py
```

PS : vous pouvez aussi lancer ce script avec un autre logiciel comme **Visual Studio** ou **Thonny** mais ne vous sera pas présenter dans ce projet.

## 🪧**Identifiants de connexion**

Pour vous connecter, il suffit d'appuyez sur le bouton `Connexion` situé en haut de notre application et d'entrez les identifications de connexion suivantes.

* Admin (permet d'accepter ou refuser des annonces publiées)

email : `admin@gmail.com`
<br>
mot de passe : `Admin1234!`

* Utilisateur de test (simple utilisateur ayant accès au site pour naviguer, enchérir et publier une annonce)

email : `test@gmail.com`
<br>
mot de passe : `Test1234!`

## ❤️Remerciements

<div style="text-align: center; padding-bottom: 40px">
<h3>Vous avez désormais accès à notre site d'enchère !</h3>

<h3>Libre à vous d'essayer toutes les fonctionnalités !</h3>

<h3>Merci pour le temps que vous consacrerez à regarder ce projet !</h3>
</div>

*Rédaction initiale : Jimmy GARNIER*
<br>
*Vérification par :*
<br>
*Date de mise à jour : 21/02/2026* 