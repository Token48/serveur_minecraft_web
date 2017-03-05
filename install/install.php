<?php
/**
 * Created by PhpStorm.
 * User: JeanMarie
 * Date: 26/02/2017
 * Time: 14:57
 */

$langue = 'fr'; //Français
$file_langue = 'install_'.$langue.'.php';
require_once($file_langue);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/mcs_bootstrap.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
    <script type="text / javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function validinput( valueid, cherche, remplace){
            var result = true;
            var bordercolor2 = '#d9534f';
            var valid = '#'+ valueid;
            var valeur = $(valid).prev('input').val();
            if (valeur == ''){
                result = false;
                var mystring = cherche;
                mystring = mystring.replace(cherche, remplace);
                $(valid).text(mystring);
                $(valid).css('color', bordercolor2);
                $(valid).prev().css('border-color', bordercolor2);
                $(valid).prev().focus();
            }
            return result;
        };
        function compinput(valueid1, valueid2, cherche, remplace){
            var result = true;
            var bordercolor2 = '#d9534f';
            var valid1 = '#'+ valueid1;
            var valid2 = '#'+ valueid2;
            var valeur1 = $(valid1).prev('input').val();
            var valeur2 = $(valid2).prev('input').val();
            if (valeur1 != valeur2){
                result = false;
                var mystring = cherche;
                mystring = mystring.replace(cherche, remplace);
                $(valid1).text(mystring);
                $(valid1).css('color', bordercolor2);
                $(valid1).prev().css('border-color', bordercolor2);
                $(valid2).prev().css('border-color', bordercolor2);
                $(valid1).prev().focus();
            }
            return result;
        }
    </script>
    <title>Install</title>
</head>
<body>
<?php
if (!isset($_POST['page'])) {
    ?>
    <div class="section">
        <script type="text/javascript">
        $(function(){
            $("#valid").click(function(){
                if ($('#tblprefix').prev().val() != ''){
                    $('#tblprefix').prev().val($('#tblprefix').prev().val()+'_');
                }
                var bordercolor = $("#valid").css('border-color');
                $("#dbhost").text("");
                $("#dbhost").prev().css('border-color', bordercolor);
                $("#dbport").text("");
                $("#dbport").prev().css('border-color', bordercolor);
                $("#dbname").text("");
                $("#dbname").prev().css('border-color', bordercolor);
                $("#tblprefix").text("");
                $("#tblprefix").prev().css('border-color', bordercolor);
                $("#dbuser").text("");
                $("#dbuser").prev().css('border-color', bordercolor);
                $("#dbpass").text("");
                $("#dbpass").prev().css('border-color', bordercolor);
                if ($('#dbport').prev('input').val() == ''){
                    $('#dbport').prev('input').val('3306');
                }
                var result = validinput("dbhost", "<?php echo '{{MESS_ADRESSEDB}}'; ?>", "<?php echo $mess_translate['{{MESS_ADRESSEDB}}']; ?>");
                if (result){
                    result = validinput("dbname", "<?php echo '{{MESS_DBNAME}}'; ?>", "<?php echo $mess_translate['{{MESS_DBNAME}}']; ?>");
                    if (result) {
                        result = validinput("dbuser", "<?php echo '{{MESS_DBUSER}}'; ?>", "<?php echo $mess_translate['{{MESS_DBUSER}}']; ?>");
                        if (result) {
                            result = validinput("dbpass", "<?php echo '{{MESS_DBPASS}}'; ?>", "<?php echo $mess_translate['{{MESS_DBPASS}}']; ?>");
                        }
                    }
                }
                return result;
            });
        });
        </script>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="h1 text-center"><?php echo str_replace('{{TITREH1}}', $mess_translate['{{TITREH1}}'], '{{TITREH1}}'); ?>1</h1>
                    <h3 class="h3 text-center">MySQL</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">&nbsp;</div>
                <div class="col-md-6">
                    <form class="form-horizontal" method="post" action="" autocomplete ="off">
                        <input type="hidden" name="page" value="1">
                        <div class="form-group has-feedback">
                            <label for="dbhost"
                                   class="col-md-6 text-right"><?php echo str_replace('{{ADRESSEDB}}', $mess_translate['{{ADRESSEDB}}'], '{{ADRESSEDB}}'); ?></label>
                            <div class="col-md-6">
                                <input type="text" name="dbhost" class="form-control">
                                <span id="dbhost"></span>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="dbport"
                                   class="col-md-6 text-right"><?php echo str_replace('{{DBPORT}}', $mess_translate['{{DBPORT}}'], '{{DBPORT}}'); ?></label>
                            <div class="col-md-6">
                                <input type="text" name="dbport" class="form-control" value="3306">
                                <span id="dbport"></span>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="dbname"
                                   class="col-md-6 text-right"><?php echo str_replace('{{DBNAME}}', $mess_translate['{{DBNAME}}'], '{{DBNAME}}'); ?></label>
                            <div class="col-md-6">
                                <input type="text" name="dbname" class="form-control">
                                <span id="dbname"></span>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="tblprefix"
                                   class="col-md-6 text-right"><?php echo str_replace('{{TBLPREFIX}}', $mess_translate['{{TBLPREFIX}}'], '{{TBLPREFIX}}'); ?></label>
                            <div class="col-md-6">
                                <input type="text" name="tblprefix" class="form-control">
                                <span id="tblprefix"></span>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="dbuser"
                                   class="col-md-6 text-right"><?php echo str_replace('{{DBUSER}}', $mess_translate['{{DBUSER}}'], '{{DBUSER}}'); ?></label>
                            <div class="col-md-6">
                                <input type="text" name="dbuser" class="form-control">
                                <span id="dbuser"></span>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="dbpass"
                                   class="col-md-6 text-right"><?php echo str_replace('{{DBPASS}}', $mess_translate['{{DBPASS}}'], '{{DBPASS}}'); ?></label>
                            <div class="col-md-6">
                                <input type="password" name="dbpass" class="form-control">
                                <span id="dbpass"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-6 col-md-6">
                                <input type="submit" name="submit" class="btn btn-default" id="valid" value="Envoyer">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3">&nbsp;</div>
            </div>
        </div>
    </div>
    <?php
} elseif ($_POST['page'] == 1){
    include ('includes.php');
    initdb($_POST);
    try {
        $handle = fopen('../make_config.php', 'wb');
        $tblprefix = (isset($_POST['tblprefix'])) ? $_POST['tblprefix'] : '';
        $buffer = "<?php
/*------------------------------*
 * Web Minecraft Serveur V1.0B  *
 *   Fichier de configuration   *
 * ".date('D M d H:i:s T Y')." *
 *------------------------------*/

//MySQL
\$config['Database']['dbname'] = '".$_POST['dbname']."'; //Nom de la base de données
\$config['Database']['tableprefix'] = '$tblprefix'; //Préfix pour le nom des tables dans la base de données
\$config['Database']['dbuser'] = '".$_POST['dbuser']."'; //Nom de l'utilisateur de la base de données
\$config['Database']['dbpass'] = '".$_POST['dbpass']."'; //Mot de passe pour l'utilisateur de la base de données
\$config['Database']['host'] = '".$_POST['dbhost']."'; //Url de la base de données
\$config['Database']['port'] = ".$_POST['dbport']."; //numéro de port de la base de données (généralement 3306)

//Language
/*
* Langue définit la langue d'affichage
* _fr pour Français
* modifier 'LANGUE' par l'extantion de votre langue (Ex: us pour usa)
* cette extension complete le nom du fichier file_xx.php du répertoire langues
* contenant la traduction des messages
*/
\$config['Language']['pays'] = 'fr'; //Français

//Chemin du complet du site
\$config['Chemin']['site'] = __DIR__;

";
        if ($handle) {
            fwrite($handle, $buffer);
            fclose($handle);
        }
    } catch (Exception $err) {
        echo str_replace('{{MESS_ERREURFILE}}', $mess_translate['{{MESS_ERREURFILE}}'], '{{MESS_ERREURFILE}}');
        die;
    }
?>
<div class="section">
    <script type="text/javascript">
        $(function(){
            $("#valid").click(function(){
                var bordercolor = $("#valid").css('border-color');
                $("#aduser").text("");
                $("#aduser").prev().css('border-color', bordercolor);
                $("#adpass").text("");
                $("#adpass").prev().css('border-color', bordercolor);
                $("#validpass").text("");
                $("#validpass").prev().css('border-color', bordercolor);
                $("#ademail").text("");
                $("#ademail").prev().css('border-color', bordercolor);
                $("#validemail").text("");
                $("#validemail").prev().css('border-color', bordercolor);
                var result = validinput("aduser", "<?php echo '{{MESS_USER}}'; ?>", "<?php echo $mess_translate['{{MESS_USER}}']; ?>");
                if (result){
                    result = validinput("adpass", "<?php echo '{{MESS_PASS}}'; ?>", "<?php echo $mess_translate['{{MESS_PASS}}']; ?>");
                    if (result){
                        result = validinput("validpass", "<?php echo '{{MESS_VALIDPASS}}'; ?>", "<?php echo $mess_translate['{{MESS_VALIDPASS}}']; ?>");
                        if (result){
                            result = compinput("adpass", "validpass", "<?php echo '{{MESS_DIFFPASS}}'; ?>", "<?php echo $mess_translate['{{MESS_DIFFPASS}}']; ?>");
                            if (result){
                                result = validinput("ademail", "<?php echo '{{MESS_EMAIL}}'; ?>", "<?php echo $mess_translate['{{MESS_EMAIL}}']; ?>");
                                if (result){
                                    result = validinput("validemail", "<?php echo '{{MESS_VALIDEMAIL}}'; ?>", "<?php echo $mess_translate['{{MESS_VALIDEMAIL}}']; ?>");
                                    if (result){
                                        result = compinput("ademail", "validemail", "<?php echo '{{MESS_DIFFEMAIL}}'; ?>", "<?php echo $mess_translate['{{MESS_DIFFEMAIL}}']; ?>");
                                    }
                                }
                            }
                        }
                    }
                }
                return result;
            });
        });
    </script>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="h1 text-center"><?php echo str_replace('{{TITREH1}}', $mess_translate['{{TITREH1}}'], '{{TITREH1}}'); ?>2</h1>
                <h3 class="h3 text-center"><?php echo str_replace('{{USERADMIN}}', $mess_translate['{{USERADMIN}}'], '{{USERADMIN}}'); ?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-6">
                <form class="form-horizontal" method="post" action="" autocomplete ="off">
                    <input type="hidden" name="page" value="2">
                    <input type="hidden" name="tblprefix" value="<?php echo $tblprefix; ?>">
                    <input type="hidden" name="dbhost" value="<?php echo $_POST['dbhost']; ?>">
                    <input type="hidden" name="dbuser" value="<?php echo $_POST['dbuser']; ?>">
                    <input type="hidden" name="dbpass" value="<?php echo $_POST['dbpass']; ?>">
                    <input type="hidden" name="dbname" value="<?php echo $_POST['dbname']; ?>">
                    <input type="hidden" name="dbport" value="<?php echo $_POST['dbport']; ?>">
                    <div class="form-group has-feedback">
                        <label for="aduser"
                               class="col-md-6 text-right"><?php echo str_replace('{{ADUSER}}', $mess_translate['{{ADUSER}}'], '{{ADUSER}}'); ?></label>
                        <div class="col-md-6">
                            <input type="text" name="aduser" class="form-control">
                            <span id="aduser"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="adpass"
                               class="col-md-6 text-right"><?php echo str_replace('{{ADPASS}}', $mess_translate['{{ADPASS}}'], '{{ADPASS}}'); ?></label>
                        <div class="col-md-6">
                            <input type="password" name="adpass" class="form-control">
                            <span id="adpass"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="validpass"
                               class="col-md-6 text-right"><?php echo str_replace('{{VALIDPASS}}', $mess_translate['{{VALIDPASS}}'], '{{VALIDPASS}}'); ?></label>
                        <div class="col-md-6">
                            <input type="password" name="validpass" class="form-control">
                            <span id="validpass"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="ademail"
                               class="col-md-6 text-right"><?php echo str_replace('{{ADEMAIL}}', $mess_translate['{{ADEMAIL}}'], '{{ADEMAIL}}'); ?></label>
                        <div class="col-md-6">
                            <input type="email" name="ademail" class="form-control">
                            <span id="ademail"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="validemail"
                               class="col-md-6 text-right"><?php echo str_replace('{{VALIDEMAIL}}', $mess_translate['{{VALIDEMAIL}}'], '{{VALIDEMAIL}}'); ?></label>
                        <div class="col-md-6">
                            <input type="email" name="validemail" class="form-control">
                            <span id="validemail"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-6 col-md-6">
                            <input type="submit" name="submit" class="btn btn-default" id="valid" value="Envoyer">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3">&nbsp;</div>
        </div>
    </div>
</div>
<?php
} elseif ($_POST['page'] == 2) {
    include('includes.php');
    initadmin($_POST);
?>
<div class="section">
    <script type="text/javascript">
        $(function(){
            $("#valid").click(function(){
                var bordercolor = $("#valid").css('border-color');
                $("#mcadresse").text("");
                $("#mcadresse").prev().css('border-color', bordercolor);
                $("#queryport").text("");
                $("#queryport").prev().css('border-color', bordercolor);
                $("#rconport").text("");
                $("#rconport").prev().css('border-color', bordercolor);
                $("#passrcon").text("");
                $("#passrcon").prev().css('border-color', bordercolor);
                var result = validinput("mcadresse", "<?php echo '{{MESS_MCADRESSE}}'; ?>", "<?php echo $mess_translate['{{MESS_MCADRESSE}}']; ?>");
                if (result){
                    result = validinput("queryport", "<?php echo '{{MESS_MCQUERYPORT}}'; ?>", "<?php echo $mess_translate['{{MESS_MCQUERYPORT}}']; ?>");
                    if (result){
                        result = validinput("rconport", "<?php echo '{{MESS_MCRCONPORT}}'; ?>", "<?php echo $mess_translate['{{MESS_MCRCONPORT}}']; ?>");
                        if (result){
                            result = validinput("passrcon", "<?php echo '{{MESS_MCPASSRCON}}'; ?>", "<?php echo $mess_translate['{{MESS_MCPASSRCON}}']; ?>");
                        }
                    }
                }
                return result;
            });
        });
    </script>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="h1 text-center"><?php echo str_replace('{{TITREH1}}', $mess_translate['{{TITREH1}}'], '{{TITREH1}}'); ?>3</h1>
                <h3 class="h3 text-center"><?php echo str_replace('{{MCSERVEUR}}', $mess_translate['{{MCSERVEUR}}'], '{{MCSERVEUR}}'); ?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-6">
                <form class="form-horizontal" method="post" action="" autocomplete ="off">
                    <input type="hidden" name="page" value="3">
                    <div class="form-group has-feedback">
                        <label for="mcadresse"
                               class="col-md-6 text-right"><?php echo str_replace('{{MCADRESSE}}', $mess_translate['{{MCADRESSE}}'], '{{MCADRESSE}}'); ?></label>
                        <div class="col-md-6">
                            <input type="text" name="mcadresse" class="form-control">
                            <span id="mcadresse"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="mcqueryport"
                               class="col-md-6 text-right"><?php echo str_replace('{{MCQUERYPORT}}', $mess_translate['{{MCQUERYPORT}}'], '{{MCQUERYPORT}}'); ?></label>
                        <div class="col-md-6">
                            <input type="text" name="queryport" class="form-control">
                            <span id="queryport"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="rconport"
                               class="col-md-6 text-right"><?php echo str_replace('{{MCRCONPORT}}', $mess_translate['{{MCRCONPORT}}'], '{{MCRCONPORT}}'); ?></label>
                        <div class="col-md-6">
                            <input type="text" name="rconport" class="form-control">
                            <span id="rconport"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="passrcon"
                               class="col-md-6 text-right"><?php echo str_replace('{{MCPASSRCON}}', $mess_translate['{{MCPASSRCON}}'], '{{MCPASSRCON}}'); ?></label>
                        <div class="col-md-6">
                            <input type="password" name="passrcon" class="form-control">
                            <span id="passrcon"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-6 col-md-6">
                            <input type="submit" name="submit" class="btn btn-default" id="valid" value="Envoyer">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3">&nbsp;</div>
        </div>
    </div>
</div>
<?php
} elseif ($_POST['page'] == 3) {
    include('includes.php');
    try {
        $handle = fopen('../make_config.php', 'ab+');
        $tblprefix = (isset($_POST['tblprefix'])) ? $_POST['tblprefix'] : '';
        $buffer = "// Url serveur minecraft
// Vous devez activer query et rcon dans server.properties pour que cela fonctionne
// enable-query = true et enable-rcon = true
\$config['Sminecraft']['adresse'] = '".$_POST['mcadresse']."'; //Ip du serveur minecraft
\$config['Sminecraft']['queryport'] = ".$_POST['queryport']."; //query port (query.port dans server.properties)
\$config['Sminecraft']['rconport'] = ".$_POST['rconport']."; //port rcon (rcon.port dans server.properties)
\$config['Sminecraft']['passrcon'] = '".$_POST['passrcon']."'; // Mot de pass pour accéder a rcon (rcon.password dans server.properties)

";
        if ($handle) {
            fwrite($handle, $buffer);
            fclose($handle);
        }
    } catch (Exception $err) {
        echo str_replace('{{MESS_ERREURFILE}}', $mess_translate['{{MESS_ERREURFILE}}'], '{{MESS_ERREURFILE}}');
        die;
    }
?>
<div class="section">
    <script type="text/javascript">
        $(function(){
            $("#valid").click(function(){
                var bordercolor = $("#valid").css('border-color');
                $("#ftpadresse").text("");
                $("#ftpadresse").prev().css('border-color', bordercolor);
                $("#ftpport").text("");
                $("#ftpport").prev().css('border-color', bordercolor);
                $("#ftpuser").text("");
                $("#ftpseu").prev().css('border-color', bordercolor);
                $("#ftppass").text("");
                $("#ftppass").prev().css('border-color', bordercolor);
                $("#ftppath").text("");
                $("#ftppath").prev().css('border-color', bordercolor);
                if ($('#ftpport').prev('input').val() == ''){
                    $('#ftpport').prev('input').val('21');
                }
                var result = validinput("ftpadresse", "<?php echo '{{MESS_FTPADRESSE}}'; ?>", "<?php echo $mess_translate['{{MESS_FTPADRESSE}}']; ?>");
                if (result){
                    result = validinput("ftpuser", "<?php echo '{{MESS_FTPUSER}}'; ?>", "<?php echo $mess_translate['{{MESS_FTPUSER}}']; ?>");
                    if (result){
                        result = validinput("ftppass", "<?php echo '{{MESS_FTPPASS}}'; ?>", "<?php echo $mess_translate['{{MESS_FTPPASS}}']; ?>");
                        if (result){
                            result = validinput("ftppath", "<?php echo '{{MESS_FTPPATH}}'; ?>", "<?php echo $mess_translate['{{MESS_FTPPATH}}']; ?>");
                        }
                    }
                }
                return result;
            });
        });
    </script>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="h1 text-center"><?php echo str_replace('{{TITREH1}}', $mess_translate['{{TITREH1}}'], '{{TITREH1}}'); ?>4</h1>
                <h3 class="h3 text-center"><?php echo str_replace('{{FTPSERVEUR}}', $mess_translate['{{FTPSERVEUR}}'], '{{FTPSERVEUR}}'); ?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-6">
                <form class="form-horizontal" method="post" action="" autocomplete ="off">
                    <input type="hidden" name="page" value="4">
                    <div class="form-group has-feedback">
                        <label for="ftpadresse"
                               class="col-md-6 text-right"><?php echo str_replace('{{FTPADRESSE}}', $mess_translate['{{FTPADRESSE}}'], '{{FTPADRESSE}}'); ?></label>
                        <div class="col-md-6">
                            <input type="text" name="ftpadresse" class="form-control">
                            <span id="ftpadresse"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="ftpport"
                               class="col-md-6 text-right"><?php echo str_replace('{{FTPPORT}}', $mess_translate['{{FTPPORT}}'], '{{FTPPORT}}'); ?></label>
                        <div class="col-md-6">
                            <input type="text" name="ftpport" class="form-control" value = '21'>
                            <span id="ftpport"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="ftpuser"
                               class="col-md-6 text-right"><?php echo str_replace('{{FTPUSER}}', $mess_translate['{{FTPUSER}}'], '{{FTPUSER}}'); ?></label>
                        <div class="col-md-6">
                            <input type="text" name="ftpuser" class="form-control">
                            <span id="ftpuser"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="ftppass"
                               class="col-md-6 text-right"><?php echo str_replace('{{FTPPASS}}', $mess_translate['{{FTPPASS}}'], '{{FTPPASS}}'); ?></label>
                        <div class="col-md-6">
                            <input type="password" name="ftppass" class="form-control">
                            <span id="ftppass"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="ftppath"
                               class="col-md-6 text-right"><?php echo str_replace('{{FTPPATH}}', $mess_translate['{{FTPPATH}}'], '{{FTPPATH}}'); ?></label>
                        <div class="col-md-6">
                            <input type="text" name="ftppath" class="form-control">
                            <span id="ftppath"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-6 col-md-6">
                            <input type="submit" name="submit" class="btn btn-default" id="valid" value="Envoyer">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3">&nbsp;</div>
        </div>
    </div>
</div>
<?php
} elseif ($_POST['page'] == 4) {
    include('includes.php');
    try{
        $handle = fopen('../make_config.php', 'ab+');
        $buffer = "//\$config['Sminecraft']['serverproperties'] = \$config['Chemin']['site'].'/repertoire_du_serveur/server.properties';

//FTP
\$config['ftp']['adresse'] = '".$_POST['ftpadresse']."'; //adresse du ftp
\$config['ftp']['port'] = ".$_POST['ftpport']."; //Port FTP (généralement 21)
\$config['ftp']['username'] = '".$_POST['ftpuser']."'; // username ftp
\$config['ftp']['password'] = '".$_POST['ftppass']."'; //password ftp
\$config['ftp']['path'] = '".$_POST['ftppath']."'; //répertoire server.properties
\$config['ftp']['serverproperties'] = 'ftp://'.\$config['ftp']['username'].':'.\$config['ftp']['password'].'@'.\$config['ftp']['adresse'].':'.\$config['ftp']['port'].'/'.\$config['ftp']['path'].'server.properties';

\$config['minecraft_site']['navbar'] = true; //affiche la barre de navigation si True
\$config['minecraft_site']['footer'] = true; //affiche le bas de page si True
";
    } catch (Exception $err) {
        echo str_replace('{{MESS_ERREURFILE}}', $mess_translate['{{MESS_ERREURFILE}}'], '{{MESS_ERREURFILE}}');
        die;
    }
    if ($handle) {
        fwrite($handle, $buffer);
        fclose($handle);
    }
    rename('../make_config.php', '../config.php');
    //todo Renommer ce fichier config.php à la dernière étape d'installation
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h1 text-center"><?php echo str_replace('{{TITREH1}}', $mess_translate['{{TITREH1}}'], '{{TITREH1}}'); ?>4</h1>
            <h3 class="h3 text-center"><?php echo str_replace('{{LASTETAPE}}', $mess_translate['{{LASTETAPE}}'], '{{LASTETAPE}}'); ?></h3>
        </div>
        <div class="col-md-12">
            <div class="text-center"><?php echo str_replace('{{DELETEINSTALL}}', $mess_translate['{{DELETEINSTALL}}'], '{{DELETEINSTALL}}'); ?></div>
        </div>
    </div>
</div>
<?php
}
?>
</body>
</html>
