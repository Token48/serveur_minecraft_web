<?php
/**
 * Created by PhpStorm.
 * User: JeanMarie
 * Date: 22/03/2017
 * Time: 10:06
 */
define('AJAXPHP', 'AJAXPHP');

require_once('config.php');
require_once ('lib/includes.php');

$config['Language']['pays'] = (isset($_COOKIE["langue"])) ? $_COOKIE["langue"] : $config['Language']['pays']; //aucune valeur definit? prendre la langue par défaut
$file_langue = $config['Chemin']['site'] . '/langues/langue_' . $config['Language']['pays'] . '.php';
require_once($file_langue);

$request = (isset($_REQUEST['operation']))? $_REQUEST['operation'] : '';
switch ($request) {
    case 'playersname':
        $playersName = get_players_connect($config);
        if ($playersName !== false) {
            //{"reponse":"Anne-Sohpie,Zembla,Raoul,Nicholas"}
            echo json_encode(array('reponse' => $playersName));
        }
        break;
    default:
        echo json_encode(array('reponse' => '-1')); //invalide
}

function get_players_connect($config){
    global $mess_translate;
    require_once('minecraft.php');
    $rcon = rcon($config);
    $Query = '';
    if ($rcon) {
        $Query = query($rcon, $config); //Recupérer status serveur
    }
    return getInfoPlayers($Query, $config, $mess_translate);
}