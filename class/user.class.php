<?php
if (!defined('INDEXPHP') && !defined('LOGINPHP')) {
    header('location: index.php');
    exit();
}
require_once($config['Chemin']['site'] . '/langues/class_user_' . $config['Language']['pays'] . '.php');
require_once($config['Chemin']['site'] . '/langues/errmysql_' . $config['Language']['pays'] . '.php');

/**
 * la classe user sert à gérer l'utilisateur actuellement connecté sur le site.
 *
 * @author JeanMarie
 */
class user
{


    /**
     * @var int
     */
    private $_user_id;
    // id
    /**
     * @var string
     */
    private $_user_name;
    // Pseudo
    /**
     * @var int
     */
    private $_user_inscription;
    // Date d'inscription sur le site et non sur le serveur du jeux
    /**
     * @var string
     */
    private $_user_email;
    // email
    /**
     * @var string
     */
    private $_user_password;
    // mot de pass utilisateur crypter avec password_hash()
    /**
     * @var int
     */
    private $_user_ip;
    // Ip 'entier stocké dans la Base de données voir mysql INET_ATON et INET_NTOA mais on passe par ip2long() et long2ip ()
    /**
     * @var int
     */
    private $_user_bannissement;
    // Membre banni? (True = oui)
    /**
     * @var int
     */
    private $_user_lvl;
    // Niveau du membre (0 invité ... 4 Administrateur)
    /**
     * @var string
     */
    private $_user_session;
    // session utilisateur

    /**
     * Classe contenant les informations de touts les utilisateurs connectés.<br />
     * <b>$uname</b> peut contenir le nom de l'utilisateur, dans ce cas <b>$upass</b> doit contenir le mot de passe ou<br />
     * <b>$uname</b> contient la session et dans ce cas <b>$upass</b> est null
     *
     * @param string $uname
     * @param string $upass [optional]
     *            = NULL
     */
    function __construct($uname, $upass = NULL)
    {
        global $config;
        $validuser = false; //par defaut l'utilisateur n'est pas reconnue

        // Connecter l'utilisateur (appeller depuis login.php)
        $mysqli = new mysqli($config['Database']['host'], $config['Database']['dbuser'], $config['Database']['dbpass'], $config['Database']['dbname'], $config['Database']['port']);
        if ($mysqli->connect_errno) {
            //Erreur de connexion à mysql
            throw new Exception(MESS_ERREURCONNECTMYSQL);
        } else {
            //Connection établie
            $uname = $mysqli->real_escape_string($uname); // NULL, \x00, \n, \r, \, ', " et \x1a éviter injection SQL
            if (isset($upass)) {
                // nouvel utilisateur
                $requete = "SELECT `iduser`, `username`, `date_inscription`, `email`, `password`, `ipuser`, `bannissement`, `levelutilisateur_lvlmembre` FROM `utilisateurs` WHERE `username` = '" . $uname . "';";
                $result = $mysqli->query($requete);
                if ($result) {
                    $this->init_user($result);

                    $result->close();
                    if ($config['DEBUG']) {
                        var_dump($uname, $upass, $this->_user_password);
                    }
                    //Controller la validité du mot de passe
                    if (!$validuser = $this->check_user($upass)) {
                        //tester si pass cookie
                        $validuser = $this->check_usercookie($upass);
                    }
                }
            } else {
                // $upass est NULL on en déduit que c'est une session
                // controller la session
                $requete = "SELECT `session`.`idsession`, `session`.`sessionhash`, `session`.`expire`, `session`.`utilisateurs_iduser`
                            FROM `session` INNER JOIN `utilisateurs`
                            ON (`session`.`utilisateurs_iduser` = `utilisateurs`.`iduser`)
                            WHERE `utilisateurs`.`username` = '$uname'";
                $result = $mysqli->query($requete);
                if ($result) {
                    // tester si la session est valide (expiration + ip)
                    $session = array();
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        foreach ($row as $key => $donn) { // http://php.net/manual/fr/control-structures.foreach.php
                            // echo "[".$key."='".$donn."']",'&nbsp;';
                            switch ($key) {
                                case "idsession":
                                    $session['idsession'] = $donn;
                                    break;
                                case "sessionhash":
                                    $session['sessionhash'] = $donn;
                                    break;
                                case "expire":
                                    $session['expire'] = $donn;
                                    break;
                                case "utilisateurs_iduser":
                                    $session['utilisateurs_iduser'] = $donn;
                                    break;
                            }
                        }
                    }
                    // expiration
                    if (retMktimest($session['expire']) < time()) {
                        setcookie('sessionhash', NULL, -1); // Effacer le cookie de session
                        $result = $mysqli->query("DELETE FROM `session` WHERE `idsession` = '" . $session['idsession'] . "';"); // on efface l'entrée dans la base de donnée
                        throw new Exception(MESS_ERREURSESSIONEXPIRE); // session expirée
                    } else {
                        //Session valide et utilisateur valide
                        $requete = "SELECT `iduser`, `username`, `date_inscription`, `email`, `password`, `ipuser`, `bannissement`, `levelutilisateur_lvlmembre` FROM `utilisateurs` WHERE `iduser` = '" . $session['utilisateurs_iduser'] . "';";
                        $result = $mysqli->query($requete);
                        if ($result) {
                            $this->init_user($result);
                            $this->_user_session = $session['sessionhash'];
                            $result->close();
                        }
                        $validuser = true;
                    }
                }
            }
            $closemysqli = $mysqli->close();
            if (!$closemysqli) {
                throw new Exception(MESS_ERREURCLOSEMYSQL);
            } else {
                if ($validuser) {
                    //utilisateur valide on lui crée une session
                    if (!$this->user_create_session(isset ($session['sessionhash']) ? $session['sessionhash'] : null)) {
                        throw new Exception(MESS_ERREURSESSIONOPEN); // impossible de créer une session
                    }
                }

            }
        }
        if (!$validuser) {
            throw new Exception(MESS_ERREURLOGIN); // mot de passe incorrect on génère une Exception
        }
    }

    /**
     * Initialise user Sauf la session
     * @param $user
     */
    private function init_user($user)
    {
        while ($row = $user->fetch_array(MYSQLI_ASSOC)) {
            foreach ($row as $key => $donn) {
                switch ($key) {
                    case "iduser":
                        $this->_user_id = $donn;
                        break;
                    case "username":
                        $this->_user_name = $donn;
                        break;
                    case "date_inscription":
                        $this->_user_inscription = $donn;
                        break;
                    case "email":
                        $this->_user_email = $donn;
                        break;
                    case "password":
                        $this->_user_password = $donn;
                        break;
                    case "ipuser":
                        $this->_user_ip = long2ip($donn);
                        break;
                    case "bannissement":
                        $this->_user_bannissement = $donn;
                        break;
                    case "levelutilisateur_lvlmembre":
                        $this->_user_lvl = $donn;
                        break;
                }
            }
        }
    }

    // --------------------------------------------------------------------
    // Retourne les infos de l'utilisateur

    /**
     * Vérifier la validité de la connexion avec pass normal
     * @param $upass
     * @return bool
     */
    private function check_user($upass)
    {
        // pass non crypté
        $boolcheck = false;
        if (password_verify($upass, $this->_user_password)) {
            $boolcheck = true;
        }
        return $boolcheck;
    }

    /**
     * Vérifier la validité de la connexion avec pass cookie
     * @param $upass
     * @return bool
     */
    private function check_usercookie($upass)
    {
        // pass déjà crypté (cookie)
        global $cbsaveuser;
        $boolcheck = false;
        if ($upass == $this->_user_password) {
            $cbsaveuser = true;
            $boolcheck = true;
        } else {
            $cbsaveuser = false;
        }
        return $boolcheck;
    }

    /**
     * créer une session pour l'utilisateur dont l'identifiant est passé en paramètre
     *
     * @param int $iduser
     * @return boolean
     */
    private function user_create_session($sessionhash = null)
    {
        global $config;
        $retour = true; // par defaut
        $mysqli = new mysqli($config['Database']['host'], $config['Database']['dbuser'], $config['Database']['dbpass'], $config['Database']['dbname'], $config['Database']['port']);
        if (is_null($sessionhash)) {
            //nouvelle entrée
            $graine = time() + $this->_user_id;
            $this->_user_session = sha1($graine);
            //Effacer toute les sessions ouverte pour cette utilisateur
            $result = $mysqli->query("DELETE FROM `session` WHERE `utilisateurs_iduser` = '" . $this->_user_id . "';");
            //Ouvrir une nouvelle session
            $requete = "INSERT INTO `session` VALUES (NULL, '$this->_user_session',";
            $requete .= " '" . date('Y-m-d H:i:s', time() + (24 * 60 * 60)) . "', " . $this->_user_id . ")";
        } else {
            $requete = "UPDATE `spigot`.`session` SET `expire`='" . date('Y-m-d H:i:s', time() + (24 * 60 * 60)) . "' WHERE  `utilisateurs_iduser`='$this->_user_id';";
        }
        $result = $mysqli->query($requete);
        if (!$result) {
            $this->_user_session = '';
            $retour = false; // Erreur
        }
        if (!$mysqli->close()) {
            throw new Exception(MESS_ERREURCLOSEMYSQL);
        }
        return $retour;
    }

    /**
     *
     */
    function __destruct()
    {

    }

    /**
     * Retourne le nom de l'utilisateur
     *
     * @param
     *            aucun
     * @return string
     */
    function username()
    {
        return $this->_user_name; // renvoit le pseudo
    }

    /**
     * Retourne l'identifiant de l'utilisateur
     *
     * @param
     *            aucun
     * @return integer
     */
    function id()
    {
        return $this->_user_id; // renvoit l' Id
    }

    /**
     * Retourne la date d'inscription de l'utilisateur
     *
     * @param
     *            aucun
     * @return integer
     */
    function inscription()
    {
        return $this->_user_inscription; // renvoit la date d'inscription
    }

    /**
     * Retourne l'adresse email de l'utilisateur
     *
     * @param
     *            aucun
     * @reurn l'adresse email
     */
    function email()
    {
        return $this->_user_email; // Renvoi l'adresse email
    }

    /**
     * Retourne le mot de passe crypté de l'utilisateur
     * param aucun
     * return le mot de passe crypté
     */
    function password()
    {
        return $this->_user_password; // Renvoi le mot de passe crypté
    }
    // --------------------------------------------------------------------

    /**
     * Retourne l'adresse ip de l'utilisateur
     * param aucun
     *
     * @return string
     */
    function ip()
    {
        return $this->_user_ip; // Renvoi l'Ip
    }

    /**
     * Retourne vrai si l'utilsateur est banni
     *
     * @param
     *            aucun
     *            return boolean
     */
    function bannissement()
    {
        return $this->_user_bannissement; // Renvoi True si l'utilisateur est banni
    }

    /**
     * Retourne le nivveau de l'utilisateur sur le <b>site</b>
     * param aucun
     * return integer
     */
    function lvl()
    {
        return $this->_user_lvl; // Renvoi le niveau du membre (0 à 4)
    }

    /**
     * Retourne le hash de la session de l'utilisateur
     * param aucun
     *
     * @return string
     */
    function user_session()
    {
        return $this->_user_session; // Renvoi la session de l'utilisateur
    }
} //Fin class user
?>