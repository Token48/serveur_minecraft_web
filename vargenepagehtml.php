<?php
/**
 * Created by PhpStorm.
 * User: JeanMarie
 * Date: 30/01/2017
 * Time: 16:22
 */

require_once('config.php');

/**********
 * Header *
 **********/
$header = "<!DOCTYPE html>
<html lang=" . $config['Language']['pays'] . ">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta http-equiv=\"pragma\" content=\"no-cache\" />
    <title>Serveur Minecraft</title>
     
    <!-- BOOSTRAP EST UN FRAMEWORK CSS QUI PERMET DE STYLISER LE CODE CI-DESSOUS, CA CODE LE CSS A VOTRE PLACE -->
    <link rel=\"stylesheet\" href=\"css/mcs_bootstrap.css\">
    <!--<link rel=\"stylesheet\" href=\"css/bootstrap-theme.css\">-->
    <script src=\"js/jquery.js\"></script>
    <script src=\"js/bootstrap.js\"></script>
    [[STYLEPERSO]]
</head>
";

/**********
 * Footer *
 **********/
$footer = "<!-- Footer -->
<div class=\"section\">
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"backgrdfooter col-md-12 text-center\">© 2017 JMG</div>
    </div>
  </div>
</div>
<!-- /Footer -->
";

/**********\
 * Navbar *
 **********/
$navbar = "<!--  NavBar -->
<div class=\"section\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-md-12\">
                <div class=\"navbar navbar-default navbar-fixed-top\">
                    <div class=\"container\">
                        <div class=\"navbar-header\">
                            <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#navbar-ex-collapse\">
                                <span class=\"sr-only\">Toggle navigation</span>
                                <span class=\"icon-bar\"></span>
                                <span class=\"icon-bar\"></span>
                                <span class=\"icon-bar\"></span>
                            </button>
                            <a class=\"navbar-brand\" href=\"index.php\"><span>{{MESS_MINECRAFTSERVER}}</span></a>
                        </div>
                        <div class=\"collapse navbar-collapse\" id=\"navbar-ex-collapse\">
                            <ul class=\"nav navbar-nav navbar-right\">
                                <li class=\"active\">
                                    <a href=\"index.php\">{{MESS_ACCUEIL}}</a>
                                </li>
                                <li>
                                    <a href=\"?section=serveurproperties\">{{MESS_PROPERTIE}}</a>
                                </li>
                                <li>
                                    <a href=\"#\">{{MESS_CONTACT}}</a>
                                </li>
                                [[USERNAME]]
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  /NavBar -->
";

/************
 * Bannière *
 ************/
$banniere = "<!-- Banniere -->
<div class=\"section section-primary\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-md-12\">
                <a href=\"#\"><img src=\"images/banniere.png\" class=\"center-block img-responsive\" alt = \"Banniere\"></a>
            </div>
        </div>
    </div>
</div>
<div>&nbsp;</div>
<!-- /Banniere -->
";

/************
 *   Login  *
 ************/
$login = "<!-- MESS_LOGIN -->
<div class=\"container\">
    <div class=\"row\">
        <div class=\"col-md-12 messlogin\">
            <label class=\"control-label\">{{MESS_LOGIN}}</label>
        </div>
    </div>
</div>
<!-- /MESS_LOGIN -->
<!-- Formulaire de connexion -->
<div class=\"section\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"section\">
                <div class=\"container\">
                    <div class=\"row\">
                        <div class=\"col-md-3\"></div>
                        <div class=\"col-md-6\">
                            <form class=\"form-horizontal\" role=\"form\" method=\"post\" action=\"index.php\">
                                <div class=\"form-group\">
                                    <div class=\"col-sm-3\">
                                        <label for=\"inputEmail3\" class=\"control-label\">{{MESS_INPUTUSERNAME}}</label>
                                    </div>
                                    <div class=\"col-sm-9\">
                                        <input type=\"text\" class=\"form-control\" id=\"inputEmail3\" name=\"username\" placeholder=\"{{MESS_INPUTUSERNAME}}\" required>
                                    </div>
                                </div>
                                <div class=\"form-group\">
                                    <div class=\"col-sm-3\">
                                        <label for=\"inputPassword3\" class=\"control-label\">{{MESS_INPUTPASSWORD}}</label>
                                    </div>
                                    <div class=\"col-sm-9\">
                                        <input type=\"password\" class=\"form-control\" id=\"inputPassword3\" name=\"password\" placeholder=\"{{MESS_INPUTPASSWORD}}\" required>
                                    </div>
                                </div>
                                <div class=\"form-group\">
                                    <div class=\"col-sm-offset-3 col-sm-9\">
                                        <div class=\"checkbox\">
                                            <label><input type=\"checkbox\" name=\"cbsaveuser\">{{MESS_CBSAVEUSER}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"form-group\">
                                    <div class=\"col-sm-offset-3 col-sm-9 col-md-1\">
                                        <button id='sendlogin' type=\"submit\" class=\"btn btn-default\">{{MESS_INPUTSENDLOGIN}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class=\"col-md-3\"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Formulaire de connexion -->
";

/***********
 * message *
 ***********/
$messageformat = "<!-- Message -->
<div class=\"container\">
    <div class=\"row\">
        <div class=\"col-md-12\">
            <div class=\"alert alert-dismissable {{message[0]}}\">
                <strong>{{message[1]}}</strong><br /><span>{{message[2]}}</span>
            </div>
        </div>
    </div>
</div>
<!-- /Message -->
";
/********
 * Body *
 ********/
$body = "<body>
 
<!-- ________________________________________________________________________________ -->
<!-- L'UTILISATION DE TABLEAUX N'EST PAS OBLIGATOIRE, CA N'EST QU'UNE DEMONSTRATION   -->
<!--    VOUS POUVEZ ADAPATER LE HTML A VOS BESOINS MAIS NE MODIFIEZ PAS LE PHP SAUF   -->
<!--                        SI VOUS SAVEZ CE QUE VOUS FAITES                          -->
<!-- ________________________________________________________________________________ -->

";

/******************************
 * Affiche servers.properties *
 ******************************/
$affserverpropertiesHaut = "<!-- Server properties -->
<div class=\"section\">
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-md-3\"></div>
      <div class=\"col-md-6\">
        <table class=\"table\">
          <thead>
            <tr>
              <th width=\"35%\">{{NAMEP}}</th>
              <th>{{VALP}}</th>
            </tr>
          </thead>
          <tbody>
            <tr>";
$affserverpropertiesBas = "            </tr>
          </tbody>
        </table>
      </div>
      <div class=\"col-md-3\"></div>
    </div>
  </div>
</div>
<!-- /Server properties -->
";

/****************
 * INFO SERVEUR *
 ****************/

$infoserveur = "<!-- INFO SERVEUR -->
<div class=\"row\">
    <div class=\"col-sm-6\">
        <table class=\"table table-bordered table-striped\">
            <thead>
                <tr>
                    <th colspan=\"2\">{{MESS_INFOSERVER}}&nbsp;<em>({{MESS_QUERIEDIN}} [[TIMER]]s)</em>
                </tr>
            </thead>
            <tbody>
                {{infoleft}}
            </tbody>
        </table>
    </div>
        <div class=\"col-sm-6\">
        <table class=\"table table-bordered table-striped\">
            <thead>
                <tr>
                    <th>{{MESS_PLAYERS}}</th>
                </tr>
            </thead>
            <tbody>
                [[JOUEURS]]
            </tbody>
        </table>
        <!-- Envoie de commande -->
        <table class=\"table table-bordered table-striped\">
            <thead>
                <tr>
                    <th>{{MESS_LAUNCHCOMMAND}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <form method=\"post\" role=\"form\">
                            <div class=\"input-group\">
                                <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-chevron-right\"></span></span>
                                <input type=\"text\" name=\"command\" class=\"form-control\" placeholder=\"{{MESS_INPUTCOMMAND}}\" data-cip-id=\"cIPJQ342845639\">
                                <span class=\"input-group-btn\">
                                    <input type=\"submit\" name=\"submit\" class=\"btn btn-default\" value=\"{{MESS_INPUTSENDCOMMAND}}\">
                                </span>
                            </div>
                        </form>

                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Envoie de commande -->
    </div>
</div>
<!-- /INFO SERVEUR -->
";
/*****************************
 * pas d'information serveur *
 *****************************/
$notinfoserveur = "<!-- Not info server -->
<div class=\"container\">
    <div class=\"row\">
        <div class=\"col-sm-12 \">
            <h3 align='center'>{{MESS_NOTINFOSERVER}}</h3>
        </div>
    </div>
</div>
<!-- /Not info server -->
";

/*********************
 * server.properties *
 *********************/
$serverproterties = "<!-- Server properties read-->
<div class=\"section\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-md-2\">&nbsp;</div>
            <div class=\"col-md-8\">
                <label>serveur.properties</label>
                <table class=\"table table-striped\">
                    <thead>
                        <tr>
                            <th width='35%'>{{MESS_PROPERTIES}}</th><th>{{MESS_VALUES}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        [[PROPERTIE-VALUE]]
                    </tbody>
                </table>
            </div>
            <div class=\"col-md-2\">&nbsp;</div>
        </div>
    </div>
</div>
<!-- Server properties read-->
";
$serverprotertiesform = "<!-- Server properties form -->
<div class=\"section\">
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-md-2\">&nbsp;</div>
      <div class=\"col-md-8\">
        <form class=\"form-horizontal\" method='post' action=\"index.php\">
          <input type='hidden' name='section' value='serveurproperties'> 
          <input type='hidden' name=\"message\" value=\"{{MESS_RELOADMC}}\">
[[INPUTFORM]]          <div class=\"form-group\">
            <div class=\"col-sm-offset-4 col-sm-8\">
              <input type=\"submit\" name=\"submit\" class=\"btn btn-default\" value=\"{{MESS_INPUTSENDCOMMAND}}\">
            </div>
          </div>
        </form>
      </div>
      <div class=\"col-md-2\">&nbsp;</div>
    </div>
  </div>
</div>
<!-- /Server properties form -->
";