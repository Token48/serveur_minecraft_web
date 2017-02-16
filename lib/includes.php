<?php

/**
 * make an http POST request and return the response content
 * @param string $url url of the requested script
 * @param array $data hash array of request variables
 * @return Return a string containing the generated html page
 */
function http_post($url, $data)
{
    $data_url = http_build_query($data);
    $data_len = strlen($data_url);
    $http_response_header = array(
        'HTTP/1.1 200 OK',
        'Connection: close'
    );
    $content = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => "Connection: close\r\nContent-Length: $data_len\r\nContent-type: application/x-www-form-urlencoded\r\nContent-Language: fr\r\n",
            'content' => $data_url
        )
    )));
    return $content;
}

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
 * pour afficher le formulaire de modification server.propreties
 * ou une chaine vide si il y a un problème.
 *
 * @param
 *            chemin du fichier de configuration ($config['Sminecraft']['serverproperties'])
 * @return string Formulaire HTML
 */
function readserverproperties($configfile)
{
    global $config, $user;
    $serverproperties = array();
    try {
        if ($configfile != '') {
            $handle = fopen($configfile, 'rb'); // ouvrir server.properties en lecture
            if ($handle) {
                // $serverproperties = fread($handle, filesize($config['Sminecraft']['serverproperties']));
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
                if ($config['DEBUG']) {
                    var_dump($serverproperties);
                }
                /* On ferme le fichier */
                fclose($handle);
            }
        }
    } catch (Exception $err) {
        $GLOBALS['message'] = $err->getMessage();
    }
    return $serverproperties;
}

function writeserverproperties($tblproperties)
{
    $debfile = "#Minecraft server properties
#" . date('D M H:i:s T Y');
    //todo finaliser la sauvegarde de server properties
}

/**
 * Génère un formulaire HTML
 * @param array $tableau
 * @return string
 */
function generate_form_serverproperties($tableau)
{
    $input = '';
    $tdx = 1;
    if (is_array($tableau)) {
        foreach ($tableau as $name => $value) {
            $tdx = ($tdx == 1) ? 2 : 1;
            $input .= "          <div class=\"form-group has-feedback\">
              <label for=\"$name\" class=\"col-sm-4 control-label td" . $tdx . "color1\" contenteditable=\"true\">$name</label>
            <div class=\"col-sm-8\">
              <input type=\"text\" class=\"form-control\" id=\"$name\" name=\"$name\" value=\"$value\">
            </div>
          </div>
";
        }
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
    //                            <td class="td1color1">[[PROPERTIE]]</td><td class="td1color2">[[VALEUR]]</td>
    $tbl = '';
    $tdx = 1;
    foreach ($tableau as $name => $value) {
        $tdx = ($tdx == 1) ? 2 : 1;
        //$tbl .="<tr><td class=\"td".$tdx."color1\">$name</td><td class=\"td".$tdx."color2\">$value</td></tr>
        $tbl .= "<tr><td class=\"td" . $tdx . "color1\">$name</td><td>$value</td></tr>
                        ";
    }
    return $tbl;
}

/**
 * Controller la validiter de la session
 * @param $hashsession
 * @return pointeur sur le resultat ou -1
 */
function validate_session($hashsession)
{
    global $config;
    $result = null;
    $mysqli = new mysqli($config['Database']['host'], $config['Database']['dbuser'], $config['Database']['dbpass'], $config['Database']['dbname'], $config['Database']['port']);
    if ($mysqli->connect_errno) {
        //Erreur de connexion à mysql
        throw new Exception(MESS_ERREURCONNECTMYSQL);
    } else {
        $hashsession = $mysqli->real_escape_string($hashsession);
        $requete = "SELECT `utilisateurs`.`username` FROM `utilisateurs` INNER JOIN `session` ON (`utilisateurs`.`iduser` = `session`.`utilisateurs_iduser`) WHERE `session`.`sessionhash` = '$hashsession'";
        $result = $mysqli->query($requete);
        if ($result->num_rows == 0) {
            //pas trouvé l'utilisateur correspondant
            $result = null;
        }
    }
    return $result;
}

/*
*  Function ustr_replace for "unique str_replace"
*  Replace a string only once in a string
*
*  Params :
*         @search  : string
*         @replace : string
*         @subject : string
*         @cur     : int
*
*  Note : if $cur is empty only the first occurence of $search will be replace else the function will take the next occurence after $cur (int position)
*
*  return string
*/
/**
 * @param $search
 * @param $replace
 * @param $subject
 * @param int $cur
 * @return mixed
 */
function ustr_replace($search, $replace, $subject, $cur = 0)
{
    $pos = strpos($subject, $search, $cur);
    if ($pos !== false) {
        $subject = substr_replace($subject, $replace, (int)strpos($subject, $search, $cur), strlen($search));
    }
    return $subject;
}//ustr_replace
?>