<?php
/**
 * Created by PhpStorm.
 * User: JeanMarie
 * Date: 05/02/2017
 * Time: 20:13
 */
define('LOGINPHP', 'LOGINPHP');

require_once('config.php');
require_once('lib/includes.php');

require_once __DIR__ . '/class/user.class.php';
$session = null; //par défaut cession non valide ou inexistante

if (isset($_COOKIE['sessionhash'])) {
//récupérer l'utilisateur au cookie de session
    $username = '';
    $session = validate_session($_COOKIE['sessionhash']); //Contrôle si la session existe
    if ($session != null) {
        //la session existe
        while ($row = $session->fetch_array(MYSQLI_ASSOC)) {
            foreach ($row as $key => $donn) {
                switch ($key) {
                    case 'username':
                        $username = $donn; //on récupère le nom de l'utilsateur
                        break;
                }
            }
        }

        if ($username != '') {
            try {
                $user = new user($username);
            } catch (Exception $err) {
                //????? Bizarre on a trouver $username plus haut dans la base de donnée
                echo $err->getMessage();
                exit();
            }

        }

    }
}
if ($session == null) {
    /**************************************/
    /*              A enlever             */
    /**************************************/
    /** $_POST['username'] = 'test1'; /**/
    /** $_POST['password'] = 'test1';/**/
    /**************************************/
    $username = (isset($_POST['username'])) ? $_POST['username'] : ((isset($_COOKIE['username'])) ? $_COOKIE['username'] : '');
    $password = (isset($_POST['password'])) ? $_POST['password'] : ((isset($_COOKIE['password'])) ? $_COOKIE['password'] : '');
    $cbsaveuser = (isset($_POST['cbsaveuser'])) ? $_POST['cbsaveuser'] : '';
    if ($username != '' && $password != '') {
        try {
            //créer l'utilisateur'
            $user = new user($username, $password);
        } catch (Exception $err) {
            //L'utilisateur n'a pas pue être créé
            //erreur $username ou $password
            $message = $err->getMessage();
        }
        if ($cbsaveuser) {
            //créer les cookies
            setcookie('username', $user->username(), time() + 3600 * 24 * 90); // $_COOKIE['username'] valable 90 jours
            setcookie('password', $user->password(), time() + 3600 * 24 * 90); // $_COOKIE['password'] valable 90 jours
        } else {
            // Effacer les cookies
            setcookie('user', NULL, -1);
            setcookie('password', NULL, -1);
        }
    }
}
if ($user) {
    setcookie('sessionhash', $user->user_session());
}
