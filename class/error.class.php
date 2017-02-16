<?php

class erreur
{

    function erreur_handler($no, $str, $file, $line)
    {
        switch ($no) {
            // Erreur fatale
            case E_USER_ERROR:
                echo '<p><strong>Erreur fatale</strong> : ' . $str . '</p>';
                exit(); // on arrete le script
                break;

            // Avertissement
            case E_USER_WARNING:
                echo '<p><strong>Avertissement</strong> : ' . $str . '</p>';
                break;

            // Note
            case E_USER_NOTICE:
                echo '<p><strong>Note</strong> : ' . $str . '</p>';
                break;

            // Erreur générée par PHP
            default:
                echo '<p><strong>Erreur inconnue</strong> [' . $no . '] : ' . $str . '<br/>';
                echo 'Dans le fichier : "' . $file . '", à la ligne ' . $line . '.</p>';
                break;
        }
    }
}

?>