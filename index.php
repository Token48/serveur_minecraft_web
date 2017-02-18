<?php
/********************************************************************************************************
 * http://getbootstrap.com/2.3.2/index.html                                                             *
 *              info bootstrap                                                                          *
 * -----------------------------------------------------------------------------------------------------*
 * http://minecraft-ids.grahamedgecombe.com/                                                            *
 *         référence items minecraft                                                                    *
 * /give <player> <item> [quantité] [type]                                                              *
 * /give Toto minecraft:planks 10 3 Donnera a toto 10 planches de type 3 (Jungle Wood Plank)            *
 * -----------------------------------------------------------------------------------------------------*
 * https://docs.spongepowered.org/stable/fr/server/getting-started/configuration/server-properties.html *
 *                                       info server.properties                                         *
 ********************************************************************************************************/
define('INDEXPHP', 'INDEXPHP');
$section = (isset($_POST['section'])) ? $_POST['section'] : ((isset($_GET['section'])) ? $_GET['section'] : ''); //initaliser section
require_once('config.php');

//global $config;
//-----------------------------------------------------
//Activer ou désactiver le lien configuration de Navbar
$configserverproperties = (isset($config['Sminecraft']['serverproperties'])) ? $config['Sminecraft']['serverproperties'] : '';
if ($configserverproperties == ''){
    $menuconfigonoff = '<span>{{MESS_PROPERTIE}}</span>'; //Pas de fichier server.properties configuré
} else {
    $menuconfigonoff = '<a href="?section=serveurproperties">{{MESS_PROPERTIE}}</a>';
}

//-----------------------------------------------------

$serverproperties = '';
$message = '';
$mess_translate = '';
$timer = '';
$Query = '';
$user = null;
if (!isset($config['Language']['pays'])) {
    $config['Language']['pays'] = 'fr';
}
require_once($config['Chemin']['site'] . '/langues/index_' . $config['Language']['pays'] . '.php');

// recuperer eventuel message
$message = (isset($_POST['message'])) ? $_POST['message'] : '';
include 'login.php';
if ($user) {
    if ($section == '') {
        // Afficher la page minecraft
        $section = 'infoserveur';
        $gotimer = microtime();
        include 'minecraft.php';
        global $rcon;
        if (!$rcon) {
            // Le serveur est arrêté ou injoignable
            $section = 'serveuroffline';

        } else {
            $endtime = microtime();
            $timer = round($endtime - $gotimer, 4); // arrondir au 10 000 de secondes
        }
    }
} else {
    // Pas de session ouverte et pas de cookies
    $section = '';
}
if (($section == 'serveurproperties') && ($user->lvl() == 4)) {
    //$section = serveurproperties et User = OP
    if (isset($_POST['submit'])) {
        //fichier server.properties est modifier
        writeserverproperties($config['Sminecraft']['serverproperties'], $_POST['servprop']);
    }
}

$styleperso = "";
include 'template.php';

//Transmettre tout les paramètres dans un tableau
$username = ($user != null) ? $user->username() : ''; //si loguer $username $ $user->username(), dans le cac contraire on vide $username
$tblvarhtml = array(
    'username' => $username,
    'section' => $section,
    'styleperso' => $styleperso,
    'message' => $message,
    'timer' => $timer,
    'Query' => $Query,
    'menuconfigonoff' => $menuconfigonoff
);
echo generepagehtml($tblvarhtml, $mess_translate);