<?php
// --------------------------------------------------------------------------
// CONNEXION AU RCON POUR ENVOYER DES COMMANDES AU SERVEUR
// --------------------------------------------------------------------------

use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;

if (defined('INDEXPHP')) {
    require_once('class/Rcon.class.php');
    require_once('lib/includes.php');
} else {
    header('location: index.php');
}

function rcon($config)
{
    try {
        $rcon = new rcon($config['Sminecraft']['adresse'], $config['Sminecraft']['rconport'], $config['Sminecraft']['passrcon']);
        if (isset($_POST['submit'])) {
            $command = $_POST['command'];
            if (strpos($command, '/') === 0) {
                $command = ustr_replace('/', '', $command);
            }
            if ($command != '') {
                if ($rcon->Auth()) {
                    $rcon->rconCommand($command);
                }
            }
        }
    } catch (Exception $err) {
        $GLOBALS['message'] = $err->getMessage();
        $rcon = false;
    }
    return $rcon;
}

function query($rcon, $config)
{
    $Query = false;
    if ($rcon) {
        // --------------------------------------------------------------------------
        // CONNEXION AU QUERY POUR RECEVOIR DES INFORMATIONS DE VOTRE SERVEUR
        // --------------------------------------------------------------------------

        define('MQ_TIMEOUT', 1);

        Error_Reporting(E_ALL | E_STRICT);
        Ini_Set('display_errors', true);

        require __DIR__ . '/class/MinecraftQuery.class.php';

        //$Timer = MicroTime(true);
        $Query = new MinecraftQuery();

        try {
            $Query->Connect($config['Sminecraft']['adresse'], $config['Sminecraft']['queryport'], MQ_TIMEOUT);
        } catch (MinecraftQueryException $e) {
            $GLOBALS['message'] = 'alert-danger, Rcon,' . $e->getMessage();
        }
    }
    return $Query;
}
?>
