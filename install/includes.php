<?php
/**
 * Created by PhpStorm.
 * User: JeanMarie
 * Date: 26/02/2017
 * Time: 21:19
 */


function initdb(array $POST){
    //Connection à MySQL
    try {
        $mysqli = @new mysqli($POST['dbhost'], $POST['dbuser'], $POST['dbpass'], $POST['dbname'], $POST['dbport']);
        if ($mysqli->connect_error) {
            echo('<h3 class="h3 text-center"> Erreur de connexion (' . $mysqli->connect_errno . ') '
                    . $mysqli->connect_error) . '</h3>';
            echo '<br><h4 class="h4 text-center">recommencer l\'<a href="install.php">installation</a></h4>';
            exit;
        }
        //Connexion à la base de données ok
        $req = "";
        $finRequete = false;
        $tables = file("minecraft_serveur.sql"); //Là ton fichier
        foreach ($tables AS $ligne) {
            if ($ligne[0] != "-" && $ligne[0] != "") {
                $req .= $ligne;
                //Permet de repérer quand il faut envoyer l'ordre SQL...
                if ( strpos($req, ';') !== false) { //contrôler si la requête est complete
                    $req = str_replace('{{TBLPREFIX}}', $POST['tblprefix'], $req);
                    $test = explode(";", $ligne);
                    if (sizeof($test) > 1) {
                        $finRequete = true;
                    }
                }
            }
            if ($finRequete) {
                if ($stmt = $mysqli -> prepare($req)) {
                    $result = $stmt->execute();
                    if (!$result) {
                        throw new Exception("Impossible d'ins&eacute;rer la ligne:<br>" . $req . "<hr>", 100);
                    }
                }
                $req = "";
                $finRequete = false;
            }
        }
        $lvluser = array ('Invité', 'Membre', 'Superviseur', 'Bigboss');
        $req = "INSERT INTO `".$POST['tblprefix']."levelutilisateur` (`lvlname`) VALUES (?)";
        if ($stmt = $mysqli -> prepare($req)){
            foreach ($lvluser as $lvlname) {
                $stmt->bind_param('s', $lvlname);
                $stmt->execute();
            }
        }
        $mysqli->close();
    } catch (Exception $err){
        echo 'Erreur de connexion (' . $err .')';
    }
}

function initadmin($POST)
{
    //Connection à MySQL
    try {
        $mysqli = @new mysqli($POST['dbhost'], $POST['dbuser'], $POST['dbpass'], $POST['dbname'], $POST['dbport']);
        if ($mysqli->connect_error) {
            echo('<h3 class="h3 text-center"> Erreur de connexion (' . $mysqli->connect_errno . ') '
                    . $mysqli->connect_error) . '</h3>';
            echo '<br><h4 class="h4 text-center">recommencer l\'<a href="install.php">installation</a></h4>';
            exit;
        }
        $dateinit = date('Y-m-d H:i:s', time());
        $password = password_hash($POST['adpass'], PASSWORD_DEFAULT);
        $ipclient = ip2long(get_ip());
        $req = "INSERT INTO `".$POST['tblprefix']."utilisateurs` (`username`, `date_inscription`, `email`, `password`, `ipuser`, `bannissement`, `levelutilisateur_lvlmembre`)
        VALUES ('".$POST['aduser']."', '".$dateinit."', '".$POST['ademail']."', '".$password."', '".$ipclient."', '0', '4')";
        if ($stmt = $mysqli -> prepare($req)) {
            $result = $stmt->execute();
            if (!$result) {
                throw new Exception("Impossible d'ins&eacute;rer la ligne:<br>" . $req . "<hr>", 100);
            }
        }
        $mysqli->close();
    } catch (Exception $err){
        echo 'Erreur de connexion (' . $err .')';
    }

}

/**
 * Récupérer la véritable adresse IP d'un visiteur
 */
function get_ip() {
    // IP si internet partagé
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    // IP derrière un proxy
    elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    // Sinon : IP normale
    else {
        return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
    }
}