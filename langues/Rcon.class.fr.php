<?php
// French messages
$err_callscript = "Ce script php ne peut pas être appeller directement!";
if (!defined('RCONCLASSPHP')) :
    echo '<p><h1 align="center">' . $err_callscript . '</h1></p>';
    exit();


endif;

$mess_translate['{{MESS_ERREURFSOCKOPEN}}'] = 'alert-info,Minecraft,Le serveur est arrêté!';
?>