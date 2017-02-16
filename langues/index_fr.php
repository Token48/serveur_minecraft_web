<?php
// French messages
$err_callscript = "Ce script php ne peut pas être appeller directement!";
if (!defined('INDEXPHP')) :
    echo '<p><h1 align="center">' . $err_callscript . '</h1></p>';
    exit();

endif;
// Mysql
// $mysqlerreurconnect = 'Echec lors de la connexion à  MySQL';

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
$mess_translate['{{MESS_INPUTSENDCOMMAND}}'] = 'Envoyer';
$mess_translate['{{MESS_INPUTSENDLOGIN}}'] = 'Connexion';
$mess_translate['{{MESS_QUERIEDIN}}'] = 'fourni en ';

// Login
$mess_translate['{{MESS_LOGIN}}'] = 'Connectez vous pour pouvoir accéder au site.';
$mess_translate['{{MESS_INPUTUSERNAME}}'] = 'Pseudo';
$mess_translate['{{MESS_INPUTPASSWORD}}'] = 'Mot de passe';
$mess_translate['{{MESS_CBSAVEUSER}}'] = 'Rester connecté.';

//server.properties
$mess_translate['{{MESS_PROPERTIES}}'] = 'Propriétées';
$mess_translate['{{MESS_VALUES}}'] = 'Valeurs';
$mess_translate['{{MESS_RELOADMC}}'] = 'alert-warning,Minecraft,Vous devez redémarrer le serveur pour que les modifications soient prises en compte.';
