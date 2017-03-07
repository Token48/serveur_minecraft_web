<?php
/****************************************************************
 * Listes des commandes et des items                            *
 * http://fr-minecraft.net/55-guide-des-commandes-minecraft.php *
 * http://minecraft-fr.gamepedia.com/Commandes                  *
 * http://minecraft-ids.grahamedgecombe.com/                    *
 ****************************************************************/

define('COMMANDESPHP', 'COMMANDESPHP');

/**
 * @param $filename <p>
 * contient le chemin du fichier xxx.json</p>
 * @return mixed <p>
 * retourne un objet de type json ou false</p>
 */
function read_json($filename)
{
    if (file_exists($filename)) {
        try {
            $handle = fopen($filename, 'rb');
            if ($handle) {
                $buffer = fread($handle, filesize($filename));
                fclose($handle);
                //decoder le fichier json
                return json_decode($buffer);
            }
        } catch (Exception $err) {
            $GLOBALS['message'] = $err->getMessage();
        }
    } else {
        return false;
    }
}

/**
 * @param $obj_commande <p>
 * un objet de type json (json_decode)</p>
 * @return string <p>
 * une chaine contenant la partie html de la liste de commande</p>
 */
function generate_list_commandes($obj_commande, &$headperso){
    $tamponhtml = "<!-- Liste Commandes -->\n<div class=\"section\">\n    <div class=\"container\">\n        <div class=\"row\">
            <div class=\"col-md-12\">\n                <div class='dropdown'>
                    <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>{{MESS_LSTCOMMANDES}}
                        <span class='caret'></span>
                    </button>
                    <ul class=\"dropdown-menu scrollable-menu\"  id='commandes'>\n";
    //récupérer la liste des commandes + syntax + explications
    $lstcommandes = $obj_commande->{'commandes'};
    /* /!\ IMPORTANT ne pas faire '$headerperso =' car on écrase le headerperso déja existant /!\ */
    $headperso .="    <script type=\"text/javascript\">\n        var  syntax_commande = {";
    foreach ($lstcommandes as $key=>$value){
        //générer un tableau $commandes[Nom_de_la_commande]=>[syntax][explication]
        //$key = nom de la commande, $value contenue de la commande (syntax + explication)
        //$commandes[$key] = $value;
        $headperso .= "\n            ".str_replace('-', '_', $key).": \"$value[0]\",";
        $tamponhtml .= "                        <li><a>$key</a></li>\n";
    }
    $headperso .="\n        }\n    </script>\n";
    $tamponhtml .= "                    </ul>\n                </div>
            </div>\n        </div>\n    </div>\n</div>\n<!-- /Liste commandes -->\n";
    return $tamponhtml;
}
?>