/**
 * Created by JeanMarie on 22/02/2017.
 */

function showStatus(message,timeout,add)
{
    if (typeof _statusbar == "undefined")
    {
        // ** Create a new statusbar instance as a global object
        _statusbar =
            $("<div id='_statusbar' class='statusbar'></div>")
                .appendTo(document.body)
                .show();
    }

    if (add)
    // *** add before the first item
        _statusbar.prepend( "<div style='margin-bottom: 2px;' >" + message + "</div>")[0].focus();
    else
        _statusbar.text(message)

    _statusbar.show();

    if (timeout)
    {
        _statusbar.addClass("statusbarhighlight");
        // setTimeout( function() { _statusbar.removeClass("statusbarhighlight"); },timeout);
        setTimeout(function(){_statusbar.hide(400)}, timeout);
    }
}

$(function(){
    $("#commandes li").click(function(){
        //Click sur une commande dans la liste 'Liste des commandes'
    	//transférer <li> dans la balise dont l'id est livalue
        var commande = $(this).text();
        commande = commande.replace('-', '_');
        if (syntax_commande[commande] == $(this).text()){
            $('#livalue').val($(this).text());
        } else {
            $('#livalue').val($(this).text()+' ');
        }
        $('input[id=livalue]').attr('title', syntax_commande[commande]);
        $('#livalue').focus(); //donner le focus à livalue
    })

    $("#playername td").click(function(){
        //Click sur un nom de joueur en ligne
        $('#livalue').val($('#livalue').val() + $(this).text()+' ');
        $('#livalue').focus(); //donner le focus à livalue
    });

    $("#selectlangue").change(function(){
        //poster le formulaire de changement de langue
        $("#formlangue").submit();
    });
    $('div').tooltip({delay: { show: 200, hide: 200 }});

    // $(window).keydown(function(key){
    //     switch(key.keyCode){
    //         case 38: //Flèche haut
    //             var pos = $('#openbox').findPosAbsolute();
    //             break;
    //         case 40: //Flèche bas
    //             var pos = $('#box1-menu').findPosAbsolute();
    //             break;
    //         default:
    //             var pos = $('#openbox').parent().findPosAbsolute();
    //     }
    //     showStatus(pos.x+', '+pos.y, 5000);
    // });
});

/*
 * Connaître la position d’un élément
 */
//Depuis les coordonnées de la fenêtre
jQuery.fn.extend({
   findPosAbsolute : function() {
       obj = jQuery(this).get(0);
       var curleft = obj.offsetLeft || 0;
       var curtop = obj.offsetTop || 0;
       while (obj = obj.offsetParent) {
                curleft += obj.offsetLeft
                curtop += obj.offsetTop
       }
       return {x:curleft,y:curtop};
   },
//Depuis les coordonnées gauche du parent
    findPosRelative : function() {
        obj = jQuery(this).get(0);
        var curleft = obj.offsetLeft || 0;
        var curtop = obj.offsetTop || 0;
        return {x:curleft,y:curtop};
    }
});