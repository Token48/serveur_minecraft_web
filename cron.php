<?php
/* Inutiliser par le serveur pour le moment */

define('CRONPHP', 'CRONPHP');
include_once 'config.php';
include_once('lib/includes.php');

/*
 * Purger les sessions périmées
 */

global $config;

$mysqli = new mysqli($config['Database']['host'], $config['Database']['dbuser'], $config['Database']['dbpass'], $config['Database']['dbname'], $config['Database']['port']);
if ($mysqli) {
    // éliminer les sessions périmées
    $time_actuelle = time();
    $result = $mysqli->query("SELECT * FROM `".$config['Database']['tableprefix']."session`");
    if ($result) {
        $session = array();
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            foreach ($row as $key => $donn) {
                switch ($key) {
                    case "idsession":
                        $session['idsession'] = $donn;
                        break;
                    case "sessionhash":
                        $session['sessionhash'] = $donn;
                        break;
                    case "expire":
                        $session['expire'] = $donn;
                        break;
                    case "utilisateurs_iduser":
                        $session['utilisateurs_iduser'] = $donn;
                        break;
                }
            }
            if (retMktimest($session['expire']) < $time_actuelle) {
                $resultdelete = $mysqli->query("DELETE FROM `".$config['Database']['tableprefix']."session` WHERE `idsession` = '" . $session['idsession'] . "';"); // on efface l'entrée dans la base de donnée
            }
        }
    }
    $result->close();
    $mysqli->close();
}
?>