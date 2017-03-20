<?php
/****************************************************************
 * Listes des commandes et des items                            *
 * http://fr-minecraft.net/55-guide-des-commandes-minecraft.php *
 * http://minecraft-fr.gamepedia.com/Commandes                  *
 * http://minecraft-ids.grahamedgecombe.com/                    *
 ****************************************************************/

define('COMMANDESPHP', 'COMMANDESPHP');

/**
 * @param $fileName <p>
 * contient le chemin du fichier xxx.json</p>
 * @return mixed <p>
 * retourne un objet de type json ou false</p>
 */
function read_json($fileName)
{
    if (file_exists($fileName)) {
        try {
            $handle = fopen($fileName, 'rb');
            if ($handle) {
                $buffer = fread($handle, filesize($fileName));
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
 * @param $objCommande <p>list des commandes json
 * @param $headPerso <p>head personel</p>
 * @param $tabulation <p>nombre d'espace</p>
 * @return string <p>
 * une chaîne contenant la partie html de la liste de commande</p>
 */
function generate_list_commandes($objCommande, $tabulation, &$headPerso){
    $tab = "";
    for ($i=0; $i < $tabulation; $i++){
        $tab .= " ";
    }
    $tamponHtml = "$tab<!-- Liste Commandes -->\n$tab<div class='dropdown'>
$tab    <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>{{MESS_LSTCOMMANDES}}
$tab       <span class='caret'></span>
$tab    </button>                    
$tab    <ul class=\"dropdown-menu\"  id='commandes'>\n";
    //récupérer la liste des commandes + syntax + explications
    $lstCommandes = $objCommande->{'commandes'};
    /* /!\ IMPORTANT ne pas faire '$headPerso =' car on écrase le headPerso déja existant /!\ */
    $headPerso .="    <script type=\"text/javascript\">\n        var  syntax_commande = {";
    foreach ($lstCommandes as $key=>$value){
        //générer un tableau $commandes[Nom_de_la_commande]=>[syntax][explication]
        //$key = nom de la commande, $value=>[syntax][explication]
        //$commandes[$key] = $value;
        $headPerso .= "\n            ".str_replace('-', '_', $key).": \"$value[0]\",";
        $tamponHtml .= "$tab    <li><a>$key</a></li>\n";
    }
    $headPerso .="\n        }\n    </script>\n";
    $tamponHtml .= "$tab    </ul>
{{ITEMSPLUS}}$tab</div><!--dropdown-->
";
    return $tamponHtml;
}

function generate_items_commandes($objItems, $tabulation, &$headPerso){
    $tab = "";
    for ($i=0; $i < $tabulation; $i++){
        $tab .= " ";
    }
    $tamponHtml = "$tab    <!-- Items -->
$tab    <button class=\"btn btn-default\" type=\"submit\" id='openbox'>{{MESS_OPENWINITEMS}}
$tab        <span class='caret'></span>
$tab    </button>
$tab    <div class=\"box-menu\" id=\"box1-menu\">";
    $lstItems = $objItems->{'items'};
    $headPerso .="    <script type=\"text/javascript\">\n        var openwinitems = '{{MESS_OPENWINITEMS}}';\n        var closewinitems = '{{MESS_CLOSEWINITEMS}}';\n        var  lst_items = {";
    $balance = 0;
    foreach ($lstItems as $key=>$value){
        //$value[0] = id, $value[1] = icon, $value[2] = syntax
        switch ($balance){
            case 0:
                $nameItems0 = $key;
                break;
            case 1:
                $nameItems1 = $key;
                break;
            case 2:
                $nameItems2 = $key;
                break;
            default:
        }

        $key = str_replace(' ', '_spc_', $key);
        $key = str_replace('(', '_parentO_', $key);
        $key = str_replace(')', '_parentF_', $key);
        $key = str_replace('\'', '_apostrophe_', $key);
        $key = str_replace('13', '_treize_', $key);
        $key = str_replace('11', '_onze_', $key);
        $headPerso .= "\n            ".str_replace('-', '_', $key).": \"$value[2]\",";
        switch ($balance){
            case 0:
                $tamponHtml .= "\n$tab        <div class=\"row\">            <a class=\"iditems\" id=\"$value[0]\" href='#'>\n$tab            <div class=\"col-md-4\" id=\"$value[2]\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"$value[2]\"><div class=\"col-md-1 col-md-offset-1 $value[1]\"></div><div class=\"col-md-8\">$nameItems0</div></div></a>";
                $balance = 1;
                break;
            case 1:
                $tamponHtml .= "\n$tab            <a class=\"iditems\" id=\"$value[0]\" href='#'><div class=\"col-md-4\" id=\"$value[2]\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"$value[2]\"><div class=\"col-md-1 $value[1]\"></div><div class=\"col-md-8\">$nameItems1</div></div></a>";
                $balance = 2;
                break;
            case 2:
                $tamponHtml .= "\n$tab            <a class=\"iditems\" id=\"$value[0]\" href='#'><div class=\"col-md-4\" id=\"$value[2]\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"$value[2]\"><div class=\"col-md-1 $value[1]\"></div><div class=\"col-md-8\">$nameItems2</div></div></a>\n$tab        </div><!--row-->";
                $balance = 0;
                break;
            default:
        }
    }
    if ($balance != 0){
        //<div> row pas fermé
        $tamponHtml .= "\n$tab        </div><!--row-->";
    }
    $tamponHtml .= "\n$tab    </div><!--box-menu-->";
    $tamponHtml .= "\n$tab    <!-- /Items -->\n";
    $headPerso .= "\n        }\n    </script>";
    return $tamponHtml;
}
?>