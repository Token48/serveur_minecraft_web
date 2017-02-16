<?php

function generepagehtml($tblhtml, $mess_translate)
{
    $body = '';
    $header = '';
    $banniere = '';
    $navbar = '';
    $footer = '';
    $login = '';
    $affserverpropertiesHaut = '';
    $affserverpropertiesBas = '';
    $infoserveur = '';
    $notinfoserveur = '';
    $serverproterties = '';
    $serverprotertiesform = "";
    global $config, $user;
    require_once('langues/index_' . $config['Language']['pays'] . '.php');
    if (defined('DEBUG')) {
        var_dump($config['Language']['pays']);
    }
    $messageformat = '';
    include_once('vargenepagehtml.php');

    if ($config['minecraft_site']['navbar']) {
        if ($tblhtml['username'] != '') {
            $navbaruser = "                                <li>
                                    <a href=\"#\">" . $tblhtml['username'] . "</a>
                                </li>";
        } else {
            $navbaruser = '';
        }
        $navbar = str_replace('[[USERNAME]]', $navbaruser, $navbar);
        $body .= $navbar;
    }
    $body .= $banniere;
    if (isset($Exception)):
        $body .= "<div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">" . htmlspecialchars($Exception->getMessage()) . "</div>
                        <p>" . nl2br($Exception->getTraceAsString(), false) . "</p>
                </div>";
    else:
        if ($tblhtml['message'] != '') {
            //Générer Alert
            //exemple:
            //   Type     Emmeteur              Message
            //alert-danger, MySql, Impossible d'établir une connection avec MySql
            $message = explode(',', $tblhtml['message']);
            $messageformat = str_replace('{{message[0]}}', $message[0], $messageformat); //type de l'alerte
            $messageformat = str_replace('{{message[1]}}', $message[1], $messageformat); //émetteur de l'alerte
            $messageformat = str_replace('{{message[2]}}', $message[2], $messageformat); //message de l'alerte
            $body .= $messageformat;
        }
        switch ($tblhtml['section']) {
            case 'infoserveur': //Page par defaut si utilisateur logué
                $Infofr = $tblhtml['Query']->GetInfo();
                if ($Infofr !== false):
                    $infoleft = '';
                    $infotmp = '';
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
                    if (($Players = $tblhtml['Query']->GetPlayers()) !== false):
                        $member = new mysqli($config['Database']['host'], $config['Database']['dbuser'], $config['Database']['dbpass'], $config['Database']['dbname'], $config['Database']['port']);
                        foreach ($Players as $Player):
                            //TODO recupérer le lvl du joueur
                            $lvl = 0;
                            $infoplayers .= "                <tr>
                    <td class\"lvluser" . $lvl . "\">" . htmlspecialchars($Player) . "</td>
                </tr>";
                        endforeach;
                    else:
                        $infoplayers .= "                <tr>
                    <td>{{MESS_NOTPLAYERSFOUND}}</td>
                </tr>";
                    endif;
                    $infoserveur = str_replace('[[TIMER]]', $tblhtml['timer'], $infoserveur);
                    $infoserveur = str_replace('[[JOUEURS]]', $infoplayers, $infoserveur);
                    $body .= $infoserveur;
                else:
                    //$body .= $infoserveur;
                    $body .= $notinfoserveur;
                endif;
                break;
            case 'serveuroffline':

                //break;
            case 'serveurproperties':
                $tblserverproperties = readserverproperties($config['Sminecraft']['serverproperties']);
                if ($user->lvl() != 4) {
                    $tblproperties = generate_tb_properties($tblserverproperties);
                    $serverproterties = str_replace('[[PROPERTIE-VALUE]]', $tblproperties, $serverproterties);
                    $body .= $serverproterties;
                } else {
                    $formproperties = generate_form_serverproperties($tblserverproperties); //générer le formulaire
                    $serverprotertiesform = str_replace('[[INPUTFORM]]', $formproperties, $serverprotertiesform);
                    $body .= $serverprotertiesform;
                }
                break;
            default:
                //Login user
                $body .= $login;
        }
    endif;
    if ($config['minecraft_site']['footer']) {
        $body .= $footer;
    }
    $body .= "</body>
</html>";
    $header = str_replace('[[STYLEPERSO]]', $tblhtml['styleperso'], $header);
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