<?php
/**
 * Created by PhpStorm.
 * User: JeanMarie
 * Date: 23/02/2017
 * Time: 18:42
 */

//Langue
$mess_translate['{{MESS_LANGUE}}'] = 'Languages';
$tbl_langues = array('uk' => 'English', 'fr' => 'French');

$mess_translate['{{MESS_DELETEINSTALL}}'] = 'Delete directory \'<b style=\'color: blue\'>install</b>\' and its contents.';

// Bottom

$mess_translate['{{MESS_MINECRAFTSERVER}}'] = 'Minecraft serveur';
$mess_translate['{{MESS_ACCUEIL}}'] = 'Home	';
$mess_translate['{{MESS_PROPERTIE}}'] = 'Configuration';
$mess_translate['{{MESS_CONTACT}}'] = 'Contact';

// Info serveur minecraft
$mess_translate['{{MESS_INFOSERVER}}'] = 'Server Information';
$mess_translate['{{MESS_NOTINFOSERVER}}'] = 'No information received';
$mess_translate['{{MESS_PLAYERS}}'] = 'Players';
$mess_translate['{{MESS_NOTPLAYERSFOUND}}'] = 'No player online';
$mess_translate['{{MESS_LAUNCHCOMMAND}}'] = 'Send an order';
$mess_translate['{{MESS_INPUTCOMMAND}}'] = 'Enter your order';
$mess_translate['{{MESS_TITLECMD}}'] = 'Enter your command to send to the server';
$mess_translate['{{MESS_INPUTSENDCOMMAND}}'] = 'Send';
$mess_translate['{{MESS_INPUTSENDLOGIN}}'] = 'Log in';
$mess_translate['{{MESS_QUERIEDIN}}'] = 'Supplied in ';

// Login
$mess_translate['{{MESS_LOGIN}}'] = 'CLogin to access the site.';
$mess_translate['{{MESS_INPUTUSERNAME}}'] = 'Pseudo';
$mess_translate['{{MESS_INPUTPASSWORD}}'] = 'Password';
$mess_translate['{{MESS_CBSAVEUSER}}'] = 'Stay connected.';

//Login erreur
//Décomposé en 3 parties 1) type d'alerte, 2) message en gras, 3) message
$mess_translate['{{MESS_ERREURLOGIN}}'] = 'alert-warning,Login,Connexion error. The name or password you entered is incorrect!';
$mess_translate['{{MESS_ERREURSESSIONOPEN}}'] = 'alert-danger,Session,Can not create a session!';
$mess_translate['{{MESS_ERREURSESSIONEXPIRE}}'] = 'alert-info,Session,Session timed out.';

//Menu utilisateur (navbar)
$mess_translate['{{MYPROFIL}}'] = 'My profile';
$mess_translate['{{LOGOUT}}'] = 'Log out';

//server.properties
$mess_translate['{{MESS_PROPERTIES}}'] = 'Property';
$mess_translate['{{MESS_VALUES}}'] = 'Values';
$mess_translate['{{MESS_RELOADMC}}'] = 'alert-warning,Minecraft,You must restart the server for the changes to take effect.';
$mess_translate['{{MESS_PROPERTIEUNDECLARED}}'] = 'This property is not declared.';
$mess_translate['{{MESS_FILENOTFOUD}}'] = 'alert-danger,Configuration,Check the path to <i>server.properties</i> in the <i>config.php</i> file.';

//Rcon
$mess_translate['{{MESS_ERREURFSOCKOPEN}}'] = 'alert-info,Minecraft,The server is shut down!';

//Commandes
$mess_translate['{{MESS_LSTCOMMANDES}}'] = 'List of commands';
$mess_translate['{{MESS_OPENWINITEMS}}'] = 'Open window items ';
$mess_translate['{{MESS_CLOSEWINITEMS}}'] = 'Close window items ';

// Mysql
$mess_translate['{{MESS_ERREURCLOSEMYSQL}}'] = 'alert-danger, MySql, An error occurred when MySql was closed';
$mess_translate['{{MESS_ERREURCONNECTMYSQL}}'] = 'alert-danger, MySql, Unable to connect to MySql';

//Footer
$mess_translate['{{MESS_FOOTER1}}'] = 'According to the original script of ';