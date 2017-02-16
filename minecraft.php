<?php
// --------------------------------------------------------------------------
// CONNEXION AU RCON POUR ENVOYER DES COMMANDES AU SERVEUR
// --------------------------------------------------------------------------

use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;

if (defined('INDEXPHP')) {
    require_once('class/Rcon.class.php');
    require_once('lib/includes.php');
    global $config;

    try {
        $rcon = new rcon($config['Sminecraft']['adresse'], $config['Sminecraft']['portrcon'], $config['Sminecraft']['passrcon']); // Remplacer l'ip, le port et le mot de passe par les votre
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
    if ($rcon) {
        // --------------------------------------------------------------------------
        // CONNEXION AU QUERY POUR RECEVOIR DES INFORMATIONS DE VOTRE SERVEUR
        // --------------------------------------------------------------------------

        define('MQ_TIMEOUT', 1);

        Error_Reporting(E_ALL | E_STRICT);
        Ini_Set('display_errors', true);

        require __DIR__ . '/class/MinecraftQuery.class.php';

        $Timer = MicroTime(true);
        $Query = new MinecraftQuery();

        try {
            $Query->Connect($config['Sminecraft']['adresse'], $config['Sminecraft']['port'], MQ_TIMEOUT);
        } catch (MinecraftQueryException $e) {
            $GLOBALS['message'] = 'alert-danger, Rcon,' . $e->getMessage();
        }
    }
} else {
    header('location: index.php');
}
?>
