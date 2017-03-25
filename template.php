<?php

require_once ('commandes.php');
require_once ('lib/includes.php');

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
                                        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><span class=\"glyphicon glyphicon-user\" ></span >$username<span class=\"caret\"></span></a>
                                        <ul class='dropdown-menu' role=\"menu\">
                                            <li ><a href = \"?section=profil\" ><span class=\"glyphicon glyphicon-cog\" ></span >&nbsp;&nbsp;{{MYPROFIL}}</a ></li >
                                            <li role=\"separator\" class=\"divider\"></li>
                                            <li ><a href = \"?section=logout\" ><span class=\"glyphicon glyphicon-log-in\" ></span >&nbsp;&nbsp;{{LOGOUT}}</a ></li >
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
                    $commandList = read_json('commandes_mc.json');
                    if ($commandList){
                        $infoserveur = str_replace('{{COMMANDPLUS}}', generate_list_commandes($commandList,20 , $tblhtml['headperso']), $infoserveur);
                        $itemsList = read_json('items.json');
                        if($itemsList){
                            //Afficher le bouton Ouvrir/Fermer box
                            $btnItemsList = "
            <button class=\"btn btn -default\" type=\"submit\" id='openbox'>{{MESS_OPENWINITEMS}} 
                <span class='caret'></span>
            </button>
            <div class=\"box - menu\" id=\"box1 - menu\">";
                            $infoserveur =  str_replace('{{BTNITEMSLIST}}', $btnItemsList, $infoserveur);
                            $infoserveur =  str_replace('{{ITEMSPLUS}}', generate_items_commandes($itemsList,36, $tblhtml['headperso']), $infoserveur);
                        } else {
                            $infoserveur = str_replace('{{BTNITEMSLIST}}', '', $infoserveur);
                            $infoserveur = str_replace('{{ITEMSPLUS}}', '', $infoserveur);
                        }
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
                    $infoPlayers = getInfoPlayers($tblhtml['Query'], $config, $mess_translate);
                    $infoserveur = str_replace('{{TIMER}}', $tblhtml['timer'], $infoserveur);
                    $infoserveur = str_replace('{{JOUEURS}}', $infoPlayers, $infoserveur);
                    $valColspan = count($tblhtml['Query']->GetPlayers());
                    if ($valColspan>4){
                        $valColspan = 4;
                    }
                    $infoserveur = str_replace('{{colspanPlayerName}}', $valColspan,$infoserveur);
                    $tblhtml['headperso'] .= "\n    <script type=\"text/javascript\">\n        $(function(){
            setInterval('horloge()',10000);
        })\n    </script>\n";
                    $body .= $infoserveur;
                else:
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
        $body .= str_replace('{{LIST_LANGUE}}',$tblhtml['listpays'], $footer) ;
    }
    $body .= "</body>\n</html>";
    $header = str_replace('{{HEADPERSO}}', $tblhtml['headperso'], $header);
    return translate_message($header, $mess_translate) . translate_message($body, $mess_translate);
}
