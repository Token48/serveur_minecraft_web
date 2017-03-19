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
    $headPerso .="    <script type=\"text/javascript\">\n        var  lst_items = {";
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
    $headPerso .= "\n    <script>
        $(function(){
            $('#openbox').click(function(){
                if($('#box1-menu').is(':hidden')){
                    var pos = $('#openbox').findPosAbsolute();
                    //dummy = $('#openbox').findPosAbsolute();
                    var offsetX = -200;
                    var offsetY = 32;                    
                    var maxWidth = parseInt($('#box1-menu').css('max-width'));
                    var maxHeight= 800;
                    if (pos.x - offsetX < 0){
                        offsetX =  pos.x - (pos.x * 2) // minimum position 0
                    }
                    if (offsetX + pos.x + maxWidth > $(window).width()){
                        offsetX += $(window).width()-(offsetX + pos.x + maxWidth);
                    }
                    if (offsetY + pos.y + maxHeight > $(window).height()){
                        var modifHeight =  maxHeight + ($(window).height() - (offsetY + pos.y + maxHeight));
                        $('#box1-menu').css('max-height', modifHeight+'px');
                    }
                    $('#box1-menu').css({left: pos.x + offsetX, top: pos.y + offsetY, display: 'block'}); /* Afficher les items */
                    $('#openbox').html(\"{{MESS_CLOSEWINITEMS}} <span class='caret'></span>\");
                } else {
                    $('#box1-menu').css({display: 'none'}); /* Masquer les items */
                    $('#openbox').html(\"{{MESS_OPENWINITEMS}} <span class='caret'></span>\");
                }
            });
            $(window).resize(function(){
                if($('#box1-menu').is(':visible')) {
                    var pos = $('#openbox').findPosAbsolute();
                    var offsetX = -200;
                    var offsetY = 32;
                    var maxWidth = parseInt($('#box1-menu').css('max-width'));
                    var maxHeight= 800;
                    if (pos.x - offsetX < 0){
                        offsetX =  pos.x - (pos.x * 2) // minimum position 0
                    }
                    if (offsetX + pos.x + maxWidth > $(window).width()){
                        offsetX += $(window).width()-(offsetX + pos.x + maxWidth);
                    }
                    if (offsetY + pos.y + maxHeight > $(window).height()){
                        var modifHeight =  maxHeight + ($(window).height() - (offsetY + pos.y + maxHeight));
                        $('#box1-menu').css('max-height', modifHeight+'px');
                    }
                    //showStatus('box1-menu =('+pos.x+'+'+offsetX+','+pos.y+'+'+offsetY+')', 8000);
                    $('#box1-menu').css({ left: pos.x + offsetX, top: pos.y + offsetY});
                }
            });
            $('.iditems').click(function(){
                var id2 = $(this).attr('id'); //id de <a>
                var id2Tag = '';
                var id1 = $('div:first', this).attr('id'); //id de <a>-><div>
                var pos = id2.indexOf(\":\");
                if (pos != -1){
                    //extraire le tag
                    var id2Tag = id2.substr(pos+1);
                }
                $('#livalue').val($('#livalue').val() + id1 + ' 1 '+ id2Tag);
                $('#livalue').focus(); //donner le focus à livalue
                showStatus(id1+','+id2Tag, 4000);
                $('#box1-menu').css({display: 'none'});/*Fermé la box*/
                $('#openbox').html(\"Ouvrir la box <span class='caret'></span>\");
            });
        });
    </script>";
    return $tamponHtml;
}
?>