/**
 * Created by JeanMarie on 22/02/2017.
 */
$(function(){
    $("#commandes li").click(function(){
        //Click sur une comande dans la liste 'Liste des commandes'
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
        $('#livalue').val($('#livalue').val() + $(this).text());
        $('#livalue').focus(); //donner le focus à livalue
    });

    $("#selectlangue").change(function(){
        //poster le formulaire de changement de langue
        $("#formlangue").submit();
    });
});