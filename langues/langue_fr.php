<?php
/**
 * Created by PhpStorm.
 * User: JeanMarie
 * Date: 23/02/2017
 * Time: 18:42
 * Si vous rajoutez une langue, complétez $tbl_langues dans tous les fichier langues_xx.php
 * 'les lettres du pays' => 'Le_nom_de_la_langue'
 * ex: 'de' => 'Allemand', 'ru' => 'Russe'...
 * ce qui donne langue_de.php et langue_ru.php
 */

//Langue
$mess_translate['{{MESS_LANGUE}}'] = 'Langues';
$tbl_langues = array('uk' => 'Anglais', 'fr' => 'Français');

$mess_translate['{{MESS_DELETEINSTALL}}'] = 'Effacer le répertoire \'<b style=\'color: blue\'>install</b>\' et son contenu.';

// Bottom

$mess_translate['{{MESS_MINECRAFTSERVER}}'] = 'Minecraft serveur';
$mess_translate['{{MESS_ACCUEIL}}'] = 'Accueil';
$mess_translate['{{MESS_PROPERTIE}}'] = 'Configuration';
$mess_translate['{{MESS_CONTACT}}'] = 'Contact';

// Info serveur minecraft
$mess_translate['{{MESS_INFOSERVER}}'] = 'Information serveur';
$mess_translate['{{MESS_NOTINFOSERVER}}'] = 'Pas d\'informations reçues';
$mess_translate['{{MESS_PLAYERS}}'] = 'Joueurs';
$mess_translate['{{MESS_NOTPLAYERSFOUND}}'] = 'Aucun joueur en ligne';
$mess_translate['{{MESS_LAUNCHCOMMAND}}'] = 'Envoyer une commande';
$mess_translate['{{MESS_INPUTCOMMAND}}'] = 'Entrez votre commande';
$mess_translate['{{MESS_TITLECMD}}'] = 'Entrez votre commande à envoyer au serveur';
$mess_translate['{{MESS_INPUTSENDCOMMAND}}'] = 'Envoyer';
$mess_translate['{{MESS_INPUTSENDLOGIN}}'] = 'Connexion';
$mess_translate['{{MESS_QUERIEDIN}}'] = 'fourni en ';

// Login
$mess_translate['{{MESS_LOGIN}}'] = 'Connectez vous pour pouvoir accéder au site.';
$mess_translate['{{MESS_INPUTUSERNAME}}'] = 'Pseudo';
$mess_translate['{{MESS_INPUTPASSWORD}}'] = 'Mot de passe';
$mess_translate['{{MESS_CBSAVEUSER}}'] = 'Rester connecté.';

//Login erreur
//Décomposé en 3 parties 1) type d'alerte, 2) message en gras, 3) message
$mess_translate['{{MESS_ERREURLOGIN}}'] = 'alert-warning,Login,Erreur de connexion. Le nom ou le mot de passe que vous avez rentré est incorrect!';
$mess_translate['{{MESS_ERREURSESSIONOPEN}}'] = 'alert-danger,Session,Impossible de créer une session!';
$mess_translate['{{MESS_ERREURSESSIONEXPIRE}}'] = 'alert-info,Session,Session expirée.';

//Menu utilisateur (navbar)
$mess_translate['{{MYPROFIL}}'] = 'Mon profil';
$mess_translate['{{LOGOUT}}'] = 'Se déconnecter';

//server.properties
$mess_translate['{{MESS_PROPERTIES}}'] = 'Propriétés';
$mess_translate['{{MESS_VALUES}}'] = 'Valeurs';
$mess_translate['{{MESS_RELOADMC}}'] = 'alert-warning,Minecraft,Vous devez redémarrer le serveur pour que les modifications soient prises en compte.';
$mess_translate['{{MESS_PROPERTIEUNDECLARED}}'] = 'Cette propriété n\'est pas déclarée.';
$mess_translate['{{MESS_FILENOTFOUD}}'] = 'alert-danger,Configuration,Vérifiez le chemin pour accéder à <i>server.properties</i> dans le fichier <i>config.php</i>.';

//Rcon
$mess_translate['{{MESS_ERREURFSOCKOPEN}}'] = 'alert-info,Minecraft,Le serveur est arrêté!';

//Commandes
$mess_translate['{{MESS_LSTCOMMANDES}}'] = 'Liste des commandes';

// Mysql
$mess_translate['{{MESS_ERREURCLOSEMYSQL}}'] = 'alert-danger, MySql, Une erreur c\'est produite à la fermeture de MySql';
$mess_translate['{{MESS_ERREURCONNECTMYSQL}}'] = 'alert-danger, MySql, Impossible d\'établir une connection avec MySql';

//Footer
$mess_translate['{{MESS_FOOTER1}}'] = 'd\'après le script original de ';