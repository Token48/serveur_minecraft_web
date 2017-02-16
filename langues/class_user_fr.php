<?php
// French messages
$err_callscript = "Ce script php ne peut pas être appeller directement!";
if (!defined('LOGINPHP')) :
    echo '<p><h1 align="center">' . $err_callscript . '</h1></p>';
    exit();

endif;
//Décomposé en 3 parties 1) type d'alerte, 2) message en gras, 3) message
define('MESS_ERREURLOGIN', 'alert-warning,Login,Erreur de connexion,Le nom ou le mot de passe que vous avez rentré est incorect!');
define('MESS_ERREURSESSIONOPEN', 'alert-danger,Session,Impossible de créer une session!');
define('MESS_ERREURSESSIONEXPIRE', 'alert-info,Session,Session expirée.');
?>