<?php

require_once ('commandes.php');
function generepagehtml($tblhtml, $mess_translate)
{
    $body = '';
    $header = '';
    $banniere = '';
    $navbar = '';
    $footer = '';
    $login = '';
    $infoserveur = '';
    $notinfoserveur = '';
    $serverproterties = '';
    $serverprotertiesform = "";
    $config = $tblhtml['config'];
    $user = $tblhtml['user'];
    $username = ($user != null) ? $user->username() : ''; //si loguer $username $ $user->username(), dans le cac contraire on vide $username

    require_once('langues/langue_' . $config['Language']['pays'] . '.php');

    if (defined('DEBUG')) {
        var_dump($config['Language']['pays']);
    }

    $messageformat = '';
    include_once('vargenepagehtml.php');

    if ($config['minecraft_site']['navbar']) {
        //déterminer quel partie du menu est actif
        switch ($tblhtml['section']) {
            case "serveurproperties":
                $navbar = str_replace('{{ACTIVEACUEIL}}', '', $navbar);
                $navbar = str_replace('{{ACTIVECONF}}', ' class="active"', $navbar);
                $navbar = str_replace('{{ACTIVECONTACT}}', '', $navbar);
                break;
            default:
                $navbar = str_replace('{{ACTIVEACUEIL}}', ' class="active"', $navbar);
                $navbar = str_replace('{{ACTIVECONF}}', '', $navbar);
                $navbar = str_replace('{{ACTIVECONTACT}}', '', $navbar);
        }
    }

    if ($config['minecraft_site']['navbar']) {
        //<a href=\"#\"><span class=\"glyphicon glyphicon-log-in\"></span>&nbsp;&nbsp;$username</a>
        $navbar = str_replace('{{ETATSERV}}', $tblhtml['etatserv'], $navbar);
        if ($username != '') {
            $navbaruser = "        <li class='dropdown'>
                                        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">$username<span class=\"caret\"></span></a>
                                        <ul class='dropdown-menu' role=\"menu\">
                                            <li ><a href = \"?section=logout\" ><span class=\"glyphicon glyphicon-log-in\" ></span >&nbsp;&nbsp; Se déconnecter </a ></li >
                                        </ul >
                                    </li>";
        } else {
            $navbaruser = '';
        }
        $navbar = str_replace('{{USERNAME}}', $navbaruser, $navbar);
        $navbar = str_replace('{{MENUCONFIGONOFF}}', $tblhtml['menuconfigonoff'], $navbar);
        $body .= $navbar;
    }
    $body .= $banniere;
    if (isset($Exception)) {
        $body .= "<div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">" . htmlspecialchars($Exception->getMessage()) . "</div>
                        <p>" . nl2br($Exception->getTraceAsString(), false) . "</p>
                </div>";
    } else {
        if ($tblhtml['message'] != '') {
            $body .= generate_message($tblhtml['message'], $messageformat);
        }
        switch ($tblhtml['section']) {
            case 'infoserveur': //Page par défaut si l'utilisateur est logué
                $Infofr = $tblhtml['Query']->GetInfo();
                if ($Infofr !== false):
                    $infoleft = '';
                    $infotmp = '';
                    $commandlist = read_json('commandes_mc.json');
                    if ($commandlist){
                        $infoserveur = str_replace('{{COMMANDPLUS}}', generate_list_commandes($commandlist, $tblhtml['headperso']), $infoserveur);
                    } else {
                        $infoserveur = str_replace('{{COMMANDPLUS}}', '', $infoserveur);
                    }
                    foreach ($Infofr as $InfoKey => $InfoValue):
                        if (Is_Array($InfoValue)) {
                            $infotmp .= "<pre>";
                            $value = print_r($InfoValue, true);
                            //Enlever 'Array (' + ')'
                            $value = str_replace('Array', '', $value);
                            $value = str_replace('(', '', $value);
                            $infotmp .= '    ' . trim(str_replace(')', '', $value));
                            //-----------------------
                            $infotmp .= "</pre>";
                        } else {
                            $infotmp .= htmlspecialchars($InfoValue);
                        }
                        $infoleft .= "                <tr>
                    <td>" . htmlspecialchars($InfoKey) . "</td>
                    <td>$infotmp</td>";
                        $infotmp = ''; //Vider le tampon
                    endforeach;
                    $infoleft . "                </tr>";
                    $infoserveur = translate_message($infoserveur, array('{{infoleft}}' => $infoleft));
                    $infoplayers = '';
                    if (($Players = $tblhtml['Query']->GetPlayers()) !== false) {
                        $ctrllvlsql = true; //Par défaut on contrôle le lvl utilisateur
                        $mysqli = new mysqli($config['Database']['host'], $config['Database']['dbuser'], $config['Database']['dbpass'], $config['Database']['dbname'], $config['Database']['port']);
                        if ($mysqli->connect_errno) {
                            $ctrllvlsql = false; //Problème avec MySQL on ne contrôle pas le lvl
                        }
                        foreach ($Players as $Player) {
                            $lvl = 0; //Par défaut le joueur en ligne est lvl zéro
                            if ($ctrllvlsql) {
                                $uname = $mysqli->real_escape_string($Player);
                                $requete = "SELECT ".$config['Database']['tableprefix']."utilisateurs.levelutilisateur_lvlmembre FROM ".$config['Database']['tableprefix']."utilisateurs WHERE utilisateurs.username = '$uname'";
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
                            $infoplayers .= "                <tr id='playername'>
                    <td><span  class=\"lvluser" . $lvl . "\">" . htmlspecialchars($Player) . "</span></td>
                </tr>";
                        }
                        if ($ctrllvlsql) {
                            //Fermer MySQL
                            $closemysqli = $mysqli->close();
                            if (!$closemysqli) {
                                throw new Exception(MESS_ERREURCLOSEMYSQL);
                            }
                        }
                    } else {
                        $infoplayers .= "                <tr>
                    <td>{{MESS_NOTPLAYERSFOUND}}</td>
                </tr>";
                    }
                    $infoserveur = str_replace('{{TIMER}}', $tblhtml['timer'], $infoserveur);
                    $infoserveur = str_replace('{{JOUEURS}}', $infoplayers, $infoserveur);
                    $body .= $infoserveur;
                else:
                    //$body .= $infoserveur;
                    $body .= $notinfoserveur;
                endif;
                break;
            case 'serveuroffline':

                //break;
            case 'serveurproperties':
                //Afficher les propriétés du serveur
                $tblserverproperties = readserverproperties($config['ftp']['serverproperties']);
                if (($user->lvl() != 4) && $tblserverproperties !== false) {
                    //non op sur serveur mc juste lire la configuration
                    $tblproperties = generate_tb_properties($tblserverproperties);
                    $serverproterties = str_replace('{{PROPERTIE-VALUE}}', $tblproperties, $serverproterties);
                    $body .= $serverproterties;
                } elseif ($tblserverproperties !== false) {
                    //op authoriser les modifications
                    $formproperties = generate_form_serverproperties($tblserverproperties); //générer le formulaire
                    $serverprotertiesform = str_replace('{{INPUTFORM}}', $formproperties, $serverprotertiesform);
                    $body .= $serverprotertiesform;
                } else {
                    $body.= generate_message($GLOBALS['message'], $messageformat);
                }
                break;
            default:
                //Login user
                $body .= $login;
        }
    }
    if ($config['minecraft_site']['footer']) {
        $body .= $footer;
    }
    $body .= "</body>\n</html>";
    $header = str_replace('{{HEADPERSO}}', $tblhtml['headperso'], $header);
    return $header . translate_message($body, $mess_translate);
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
