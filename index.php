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
//Tester si script installer
if (!file_exists('config.php')){
    header('Location: install/install.php');
}

require_once('config.php');

$file_langue = $config['Chemin']['site'] . '/langues/langue_' . $config['Language']['pays'] . '.php';
require_once($file_langue);
global $mess_translate;

//Script installer tester si install effacer
if (file_exists('install/install.php')){
    echo "<h1 align=\"center\">Minecraft Web</h1>\n<br><h2 align=\"center\">".str_replace('{{MESS_DELETEINSTALL}}', $mess_translate['{{MESS_DELETEINSTALL}}'], '{{MESS_DELETEINSTALL}}')."</h2>";
    die;
}

$section = (isset($_POST['section'])) ? $_POST['section'] : ((isset($_GET['section'])) ? $_GET['section'] : ''); //initaliser section

require_once('minecraft.php');

$gotimer = microtime(); //start chrono
$rcon = rcon($config);
$Query = '';
if ($rcon) {
    $Query = query($rcon, $config); //Recupérer status serveur
}
$endtime = microtime(); //stop chrono
$timer = round($endtime - $gotimer, 4); // arrondir au 10 000 de secondes
$etatserv = ($rcon) ? '<span class="glyphicon glyphicon-ok-sign lvluser2">' : '<span class="glyphicon glyphicon-remove-sign lvluser4">';

//-----------------------------------------------------
//Activer ou désactiver le lien configuration de Navbar
$configserverproperties = (isset($config['ftp']['serverproperties'])) ? $config['ftp']['serverproperties'] : '';
if ($configserverproperties == '') {
    $menuconfigonoff = '<span>{{MESS_PROPERTIE}}</span>'; //Pas de fichier server.properties configuré
} else {
    $menuconfigonoff = '<a href="?section=serveurproperties">{{MESS_PROPERTIE}}</a>';
}
//-----------------------------------------------------

$serverproperties = '';
$message = '';
$user = null;

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
        writeserverproperties($config['ftp']['serverproperties'], $_POST['servprop']);
    }
}

$headperso = "";
include 'template.php';

//Transmettre tout les paramètres dans un tableau

$tblvarhtml = array(
    'config' => $config,
    'user' => $user,
    'section' => $section,
    'headperso' => $headperso,
    'message' => $message,
    'timer' => $timer,
    'Query' => $Query,
    'menuconfigonoff' => $menuconfigonoff,
    'etatserv' => $etatserv
);
echo generepagehtml($tblvarhtml, $mess_translate);