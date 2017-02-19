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
require_once('minecraft.php');

$gotimer = microtime();
$rcon = rcon($config);
$Query = '';
if ($rcon) {
    $Query = query($rcon, $config); //Recupérer status serveur
}
$endtime = microtime();
$timer = round($endtime - $gotimer, 4); // arrondir au 10 000 de secondes
$etatserv = ($rcon) ? '<span class="glyphicon glyphicon-ok-sign lvluser2">' : '<span class="glyphicon glyphicon-remove-sign lvluser4">';

//-----------------------------------------------------
//Activer ou désactiver le lien configuration de Navbar
$configserverproperties = (isset($config['Sminecraft']['serverproperties'])) ? $config['Sminecraft']['serverproperties'] : '';
if ($configserverproperties == '') {
    $menuconfigonoff = '<span>{{MESS_PROPERTIE}}</span>'; //Pas de fichier server.properties configuré
} else {
    $menuconfigonoff = '<a href="?section=serveurproperties">{{MESS_PROPERTIE}}</a>';
}

//-----------------------------------------------------

$serverproperties = '';
$message = '';
$mess_translate = '';
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
        //Tester rcon
        if (!$rcon) {
            // Le serveur est arrêté ou injoignable
            $section = 'serveuroffline';
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

$tblvarhtml = array(
    'config' => $config,
    'user' => $user,
    'section' => $section,
    'styleperso' => $styleperso,
    'message' => $message,
    'timer' => $timer,
    'Query' => $Query,
    'menuconfigonoff' => $menuconfigonoff,
    'etatserv' => $etatserv
);
echo generepagehtml($tblvarhtml, $mess_translate);