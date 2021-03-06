<?php

/**
 * return mktime from a db (mysql) datetime (Y-m-d H:i:s)
 *
 * @param string $dbdate
 *            format "Y-m-d H:i:s"
 * @return number
 */
function retMktimest($dbdate)
{
    return mktime(substr($dbdate, 11, 2), substr($dbdate, 14, 2), substr($dbdate, 17, 2), substr($dbdate, 5, 2), substr($dbdate, 8, 2), substr($dbdate, 0, 4));
}

/**
 * Retourne la page html à afficher
 * pour afficher le formulaire de modification server.properties
 * ou une chaine vide si il y a un problème.
 *
 * @param string $configfile <p>
 * chemin du fichier de configuration ($config['ftp']['serverproperties'])
 * </p>
 *  * @return mixed array Formulaire HTML or FALSE
 */
function readserverproperties($configfile)
{
    global $user; global $mess_translate;
    $serverproperties = array();
    if (file_exists($configfile)) {
        try {
            if ($configfile != '') {
                $handle = fopen($configfile, 'rb'); // ouvrir server.properties en lecture
                if ($handle) {
                    /* Tant que l'on est pas à la fin du fichier */
                    while (!feof($handle)) {
                        /* On lit la ligne courante */
                        $buffer = trim(fgets($handle));
                        $posdiez = strpos($buffer, '#');
                        if ($posdiez !== 0) //Ce n'est pas un commentaire
                        {
                            //$serverproperties .= $buffer . '<br />';
                            $value = explode('=', $buffer);
                            if ($value[0] != '') {
                                if (isset($value[1])) {
                                    $serverproperties[$value[0]] = $value[1];
                                    if ($value[0] == 'rcon.password' && $user->lvl() != 4) {
                                        //Cacher le mot de passe rcon si pas OP
                                        $serverproperties[$value[0]] = '********';
                                    }
                                } else {
                                    $serverproperties[$value[0]] = '';
                                }
                            }
                        }
                    }
                    /* On ferme le fichier */
                    fclose($handle);
                }
            }
        } catch (Exception $err) {
            $GLOBALS['message'] = $err->getMessage();
        }
    } else {
        $GLOBALS['message'] = $mess_translate['{{MESS_FILENOTFOUD}}'];
        $serverproperties = false;
    }
    return $serverproperties;
}

/**
 * @param $configfile
 * @param $tblproperties
 */
function writeserverproperties($configfile, $tblproperties)
{
    global $mess_translate;
    $debfile = "#Minecraft server properties\n#" . date('D M d H:i:s T Y');
    if (file_exists($configfile)) {
        try {
            $handle = fopen($configfile, 'wb'); // ouvrir server.properties en lecture
            //$handle = true;
            if ($handle) {
                fputs($handle, $debfile . "\n");
                foreach ($tblproperties as $key => $don) {
                    $pos_ = strpos($key, '_');
                    if ($pos_ === 0) {
                        //premier caractère = '_' donc c'est une propriété non déclarée dans le fichier server.properties
                        if ($don != '') {
                            //Il lui a été attribué une valeur
                            $trans = array("_" => "");
                            $key = strtr($key, $trans); //supprimer _ au debut du nom de la propriété
                        }
                    }
                    $pos_ = strpos($key, '_');
                    if ($pos_ !== 0) {
                        //Deuxième contrôle au cas ou $key ne commence pas '_' (suppression de '_')
                        fputs($handle, $key . '=' . $don . "\n");
                    }
                }
                fclose($handle);
            }
        } catch (Exception $err) {
            $GLOBALS['message'] = $err->getMessage();
        }
    } else {
        $GLOBALS['message'] = $mess_translate['{{MESS_FILENOTFOUD}}'];
    }
}

/**
 * Génère un formulaire HTML
 * @param array $tableau
 * @return string
 */
function generate_form_serverproperties($tableau)
{
    global $config;
    $tblpropertie = array();
    $input = '';
    $tdx = 1;
    if (is_array($tableau)) {
        //------------------------------------------
        try {
            $handle = fopen($config['Chemin']['site'] . '/list_properties_of_server.txt', 'rb');
            $i = 0;
            while (!feof($handle)) {
                /* On lit la ligne courante */
                $buffer = trim(fgets($handle));
                if ($buffer[0] != '#') {
                    //si la ligne n'est pas un commentaire'
                    $tblpropertie[$i] = $buffer;
                    $i++;
                }
            }
            fclose($handle);
        } catch (Exception $err) {
            $GLOBALS['message'] = $err->getMessage();
        }
        //------------------------------------------
        foreach ($tableau as $name => $value) {
            $tdx = ($tdx == 1) ? 2 : 1;
            for ($i = 0; $i < count($tblpropertie); $i++) {
                if ($tblpropertie[$i] == $name) {
                    //la propriété existe on l'efface du tableau'
                    array_splice($tblpropertie, $i, 1);
                }
            }
            $input .= "          <div class=\"form-group has-feedback\">
              <label for=\"$name\" class=\"col-sm-4 control-label td" . $tdx . "color1\" contenteditable=\"true\">$name</label>
            <div class=\"col-sm-8\">
              <input type=\"text\" class=\"form-control\" id=\"$name\" name=\"servprop[$name]\" value=\"$value\">
            </div>
          </div>
";
        }
        //------------------------------------------
        //ici on rajoute un '_' devant la valeur de l'attribut name de la balise input
        //pour indiquer lors de la sauvegarde que cette propriété n'y étais à l'origine
        $tdx = 10;
        for ($i = 0; $i < count($tblpropertie); $i++) {
            $tdx = ($tdx == 10) ? 11 : 10;
            //Générer les propriété manquantes du fichier server.properties
            $input .= "          <div class=\"form-group has-feedback\">
              <label for=\"$tblpropertie[$i]\" class=\"col-sm-4 control-label td" . $tdx . "color1\" contenteditable=\"false\">$tblpropertie[$i]</label>
            <div class=\"col-sm-8\">
              <input type=\"text\" class=\"form-control\" id=\"$tblpropertie[$i]\" name=\"servprop[_$tblpropertie[$i]]\" placeholder=\"{{MESS_PROPERTIEUNDECLARED}}\">
            </div>
          </div>
";
        }
        //------------------------------------------
        $result = $input;
    } else {
        $result = '<p>Server properties invalide!<p>';
    }
    return $result;
}

/**
 * Générer html du tableau server.properties
 * @param $tableau array
 * @return string
 */
function generate_tb_properties($tableau)
{
    $tbl = '';
    $tdx = 1;
    foreach ($tableau as $name => $value) {
        $tdx = ($tdx == 1) ? 2 : 1;
        $tbl .= "<tr><td class=\"td" . $tdx . "color1\">$name</td><td>$value</td></tr>
                        ";
    }
    return $tbl;
}

/**
 * Controller la validiter de la session
 * @param $hashsession
 * @return bool|mysqli_result
 */
function validate_session($hashsession)
{
    global $config; global $mess_translate;
    $result = null;
    $mysqli = @new mysqli($config['Database']['host'], $config['Database']['dbuser'], $config['Database']['dbpass'], $config['Database']['dbname'], $config['Database']['port']);
    if ($mysqli->connect_errno) {
        //Erreur de connexion à mysql
        throw new Exception($mess_translate['{{MESS_ERREURCONNECTMYSQL}}']);
    } else {
        $hashsession = $mysqli->real_escape_string($hashsession);
        $requete = "SELECT `".$config['Database']['tableprefix']."utilisateurs`.`username` FROM `".$config['Database']['tableprefix']."utilisateurs` INNER JOIN `".$config['Database']['tableprefix']."session` ON (`".$config['Database']['tableprefix']."utilisateurs`.`iduser` = `".$config['Database']['tableprefix']."session`.`utilisateurs_iduser`) WHERE `".$config['Database']['tableprefix']."session`.`sessionhash` = '$hashsession'";
        $result = $mysqli->query($requete);
        if ($result->num_rows == 0) {
            //pas trouvé l'utilisateur correspondant
            $result = null;
        }
    }
    return $result;
}

/**
*  Function ustr_replace for "unique str_replace"
*  Replace a string only once in a string
*
*  Params :
*         @search  : string
*         @replace : string
*         @subject : string
*         @cur     : int
*
*  Note : if $cur is empty only the first occurrence of $search will be replace else the function will take the next occurrence after $cur (int position)
*
*  return string
*/
function ustr_replace($search, $replace, $subject, $cur = 0)
{
    $pos = strpos($subject, $search, $cur);
    if ($pos !== false) {
        $subject = substr_replace($subject, $replace, (int)strpos($subject, $search, $cur), strlen($search));
    }
    return $subject;
}

/**
 * Formate le message à afficher
 * @param $messagecomplet
 * @param $messageformat
 * @return mixed
 */
function generate_message($messagecomplet, $messageformat)
{
    //Générer Alert
    //exemple:
    //   Type     Emmeteur              Message
    //alert-danger, MySql, Impossible d'établir une connection avec MySql
    $message = explode(',', $messagecomplet);
    $messageformat = str_replace('{{message[0]}}', $message[0], $messageformat); //type de l'alerte
    $messageformat = str_replace('{{message[1]}}', $message[1], $messageformat); //émetteur de l'alerte
    $messageformat = str_replace('{{message[2]}}', $message[2], $messageformat); //message de l'alerte
    return $messageformat;
}

/**
 * @param $tampon string
 * @param $mess_translate array
 * @return string
 */
function translate_message($tampon, $mess_translate)
{
    foreach ($mess_translate as $key => $value) {
        $tampon = str_replace($key, $value, $tampon);
    }
    return $tampon;
}

function getInfoPlayers($query, $config, $mess_translate){
    $infoplayers = '';
    if (($players = $query->GetPlayers()) !== false) {
        $ctrllvlsql = true; //Par défaut on contrôle le lvl utilisateur
        $mysqli = new mysqli($config['Database']['host'], $config['Database']['dbuser'], $config['Database']['dbpass'], $config['Database']['dbname'], $config['Database']['port']);
        if ($mysqli->connect_errno) {
            $ctrllvlsql = false; //Problème avec MySQL on ne contrôle pas le lvl
        }
        $width = 0;
        $cr = "\n";
        $nbElements = 1;
        foreach ($players as $player) {
            $lvl = 0; //Par défaut le joueur en ligne est lvl zéro
            if ($nbElements == count($players)){
                $cr = "";
            }
            $nbElements ++;
            if ($ctrllvlsql) {
                $uname = $mysqli->real_escape_string($player);
                $requete = "SELECT ".$config['Database']['tableprefix']."utilisateurs.levelutilisateur_lvlmembre FROM ".$config['Database']['tableprefix']."utilisateurs WHERE ".$config['Database']['tableprefix']."utilisateurs.username = '$uname'";
                //Rechercher si la personne qui se trouve sur le serveur est dans la base de données
                $result = $mysqli->query($requete);
                if ($result) {
                    //lvl trouvé
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        foreach ($row as $key => $don) {
                            $lvl = $don; //Récupérer le lvl
                        }
                    }
                } else {
                    //On peut eventuellement ici kické la personne du serveur si elle n'est pas inscrit ici
                    //à l'aide d'une commande rcon...
                }
            }
            if ($width == 0){
                $balise_TrDeb = "<tr>\n";
                $balise_TrFin = "";
            } elseif ($width != 3){
                $balise_TrDeb = "";
                $balise_TrFin = "";
            } else {
                $balise_TrDeb = "";
                $balise_TrFin = "                       </tr>$cr";
            }
            $infoplayers .= "$balise_TrDeb                            <td><span  class=\"lvluser" . $lvl . "\">" . htmlspecialchars($player) . "</span></td>
$balise_TrFin";
            ($width == 3) ? $width = 0 : $width++;
        }
        if ($width != 0){
            $infoplayers .="                        </tr>$cr"; //fermer TR
        }
        if ($ctrllvlsql) {
            //Fermer MySQL
            $closemysqli = $mysqli->close();
            if (!$closemysqli) {
                throw new Exception(MESS_ERREURCLOSEMYSQL);
            }
        }
    }
    else {
        $infoplayers .= "                <tr>
                    <td>".str_replace('{{MESS_NOTPLAYERSFOUND}}', $mess_translate['{{MESS_NOTPLAYERSFOUND}}'], '{{MESS_NOTPLAYERSFOUND}}')."</td>
                </tr>";
    }
    return $infoplayers;
}

?>