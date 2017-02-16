<?php
/*------------------------------*\
 * Web Minecraft Serveur V1.0B  *
 *   Fichier de configuration   *
\*------------------------------*/

$config['DEBUG'] = false; //Active Vardump

//MySQL
$config['Database']['dbname'] = ''; //Nom de la base de données
$config['Database']['tableprefix'] = ''; //Préfix pour le nom des tables dans la base de données
$config['Database']['dbuser'] = ''; //Nom de l'utilisateur de la base de données
$config['Database']['dbpass'] = ''; //Mot de passe pour l'utilisateur de la base de données
$config['Database']['host'] = 'localhost'; //Url de la base de données
$config['Database']['port'] = 3306; //numéro de port de la base de données (généralement 3306)

//Language
/*
* Langue définit la langue d'affichage
* _fr pour Français
* modifier 'LANGUE' par l'extantion de votre langue (Ex: us pour usa)
* cette extension complete le nom du fichier file_xx.php du répertoire langues
* contenant la traduction des messages
*/
$config['Language']['pays'] = 'fr'; //Français

//Chemin du complet du site
$config['Chemin']['site'] = __DIR__;

//Url serveur minecraft
//Vous devez activer query et rcon dans server.properties pour que cela fonctionne
// enable-query = true et enable-rcon = true
$config['Sminecraft']['adresse'] = '127.0.0.1'; //Ip du serveur minecraft
$config['Sminecraft']['username'] = ''; // username ftp
$config['Sminecraft']['password'] = ''; //password ftp
$config['Sminecraft']['queyport'] = 25565; //query port (query.port dans server.properties)
$config['Sminecraft']['portrcon'] = 25575; //port rcon (rcon.port dans server.properties)
$config['Sminecraft']['passrcon'] = ''; // Mot de pass pour acéder a rcon (rcon.password dans server.properties)

//$config['Sminecraft']['serverproperties'] = 'ftp://'.$config['Sminecraft']['username'].':'.$config['Sminecraft']['password'].'@'.$config['Sminecraft']['adresse'].'/chemin pour accéder à/server.properties';

$config['minecraft_site']['navbar'] = true; //affiche la barre de navigation si True
$config['minecraft_site']['footer'] = true; //affiche le bas de page si True
