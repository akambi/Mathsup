// Variable de départ pour le slider principal
var current_slide = 1;
$(function() {  
/*  Ici on définit quelques variables de redirection */
    var protocole = "http", domaineFR = '.fr', domaineCOM = '.com';
    protocole += '://';
    protocole += 'www.';    
/*  Code du slider principal */
    var slider = $('#slider');
    slider.wrap('<div id="slider-content">');
    //  On récupère la largeur du slider
    var slider_width = $('#slider').width();
    var slider_handler = slider.children();
    //  On récupère le nombre d'image dans le slider
    var slider_content_length = slider_handler.children().length;  
    //  Ici on modifie la largeur du conteneur des images
    slider_handler.css( 'width', slider_content_length * 1000 );
    //  L'action à effectuer quand on clique sur le bouton précédent
    var precedentAction = function(){
        clearInterval(slidetimer);                
        if( current_slide === 0 ){
            current_slide = slider_content_length - 1;
        }else{
            current_slide -=1;
        }
    //  On gère la flêche dans bas de nos méthdodes
        jQuery('.content div').removeClass('active');
        jQuery('.content div').eq(current_slide).addClass('active');
    //  On anime le slider
        slider_handler.animate({"left": '-'+( current_slide * slider_width )}, { duration: 500} );     
        slidetimer=setInterval("movTo(" + slider_content_length + "," + slider_width + ")", 5000);
    };
    //  L'action à effectuer quand on clique sur le bouton suivant
    var suivantAction = function(){
        clearInterval(slidetimer);                 
        if( current_slide === ( slider_content_length - 1 ) ){
            current_slide = 0;
        }else{
            current_slide +=1; 
        }
    //  On gère la flêche dans bas de nos méthdodes
        jQuery('.content div').removeClass('active');
        jQuery('.content div').eq(current_slide).addClass('active');
    //  On anime le slider
        slider_handler.animate({"left": '-'+( current_slide * slider_width )}, { duration: 500} );
        slidetimer=setInterval("movTo(" + slider_content_length + "," + slider_width + ")", 5000);
    };
    //  L'action à effectuer quand on est sur le curseur d'un cours
    var coursCursorEnterAction = function(){
        clearInterval(slidetimer);
    //  On recupère l'index du parent .content div du curseur
        var cours_cursor_parent_index = $(this).parent().parent().index();
        cours_cursor_parent_index -=1;
    //  On met à jour le current_slide
        current_slide = cours_cursor_parent_index;
    //  On gère la flêche dans bas de nos méthdodes
        jQuery('.content div').removeClass('active');
        jQuery('.content div').eq(current_slide).addClass('active');
    //  On anime le slider
        slider_handler.animate({"left": '-'+( current_slide * slider_width )}, { duration: 500} );        
    };
    //  L'action à effectuer quand on est sortie du curseur d'un cours
    var coursCursorOutAction = function(){        
        slidetimer=setInterval("movTo(" + slider_content_length + "," + slider_width + ")", 5000);
    };    
    //  Affiche du cursor gauche du slider
    $('<img class="precedent" />')
            .attr('src', '/img/slider-left.jpg')                
            .click( precedentAction )
            .insertBefore( '#slider' );
    //  Affiche du cursor droit du slider
    $('<img class="suivant" />')
            .attr('src', '/img/slider-right.jpg')
            .click( suivantAction )
            .insertAfter( '#slider' );
    //  Le hover sur un curseur de cours
    $('.cours-curseur').mouseenter(coursCursorEnterAction);
    //  Le out hover sur un curseur de cours
    $('.cours-curseur').mouseleave(coursCursorOutAction);
    //  On retire l'action du href
    $('.cours-curseur').click(function(){ return false; });
    
    var slidetimer=setInterval("movTo(" + slider_content_length + "," + slider_width + ")", 5000);
/*  Fin du code du slider en haut de page */

//  Ajout de la numérotation des titres des articles de la catégorie niveau
    $(".niveau #tabs article").each( function( ){
        $(this)
                .children()
                .find('h2')
                .each( function( index ){
                    $(this).text((index + 1)+". "+ $(this).text()); 
                });
    });
//  On gère ici le hover sur le formulaire connexion
    $(".login-sign-in li a#member-connect").mouseenter( function( ){        
        $("#connexion-menu").show();
    });

    $(".container-fluid > section, .login-sign-in li:first a, #menu").mouseenter( function( ){        
    //  On met 5 secondes avant de cacher le formulaire de connexion
        $("#connexion-menu").delay(5000).hide('slow');
    });
/*  Le slider de la liste des membres */
    var liste_equipes = $('#liste-equipes');
    var liste_equipes_total = liste_equipes.children().length;
    //  Le nombre de projets à afficher
    var membres_a_afficher = 7;
    var membre_debut = 0;
    //  Action qui se produit quand on clic sur le bouton précédent
    var previous_action = function(){
        //  Si on est au début, on ne fait rien sinon on slide
        if( membre_debut === 0 ){
            return;
        }else{
            membre_debut -=1;
            var projet_end = membre_debut + membres_a_afficher;
            set_display_projets(liste_equipes, membre_debut, projet_end, 'previous');
            // Si on est au début du slide, cacher le bouton slider
            if( membre_debut === 0 ){
                $('#slider-footer .previous').hide();
            }
            //  Si on vient de quitter la fin du slide, on affiche le bouton next
            if( ( membre_debut + membres_a_afficher ) === ( liste_equipes_total - 1 ) ){
                $('#slider-footer .next').show();
            }
        }
    };
    //  Action qui se produit quand on clic sur le bouton suivant
    var next_action = function(){
        //  Si on est à la fin du slide, on ne fait rien, sinon on slide
        if( ( membre_debut + membres_a_afficher ) === ( liste_equipes_total ) ){
            return;
        }else{
            membre_debut +=1;
            var projet_end = membre_debut + membres_a_afficher;
            set_display_projets(liste_equipes, membre_debut, projet_end, 'next');
            //  Si on vient de démarrer le slide, on affiche le bouton previous
            if( membre_debut === 1 ){
                $('#slider-footer .previous').show();
            }
            //  Si on est à la fin du slide, on cache le bouton next
            if( ( membre_debut + membres_a_afficher ) === ( liste_equipes_total ) ){
                $('#slider-footer .next').hide();
            }
        }
    };
    //  On crée le bouton précédent du slider liste projets
        $('<img class="previous" />')
                .attr('src', '/img/slider-left.jpg')                
                .click( previous_action )
                .prependTo( '#slider-footer' );
    //  On cache le bouton previous au début
    if( membre_debut === 0 ){
        $('#slider-footer .previous').hide();
    }
    //  On crée le bouton suivant du slider liste projets
        $('<img class="next" />')
                .attr('src', '/img/slider-right.jpg')                
                .click( next_action )
                .appendTo( '#slider-footer' );
    //  On gère ici les redirections des images
        $('#liste-equipes img').click( function(){
            var index = $(this).parent().parent().index();
            alert('On se dirige vers le lien de l\'image ' + ( index + 1) );
            //window.open( protocole + 'exemple' + domaineCOM );
            return false;
        });
/*  Fin du code du slider en bas de page */
//  Ici on ajoute un script pour un bouton qui permet un retour en entête de page
    $('.btn_up').click(function() {
        $('html,body').animate({scrollTop: 0}, 'slow');
        return false;
    });
    //  On cache tous les boutons dans un premier temps
    if ($(window).scrollTop() < 500){
        $('.btn_up').stop().animate({'opacity':0},function(){
           $(this).hide()
        });
    }

    $(window).scroll(function(){

        if ($(window).scrollTop() < 500){
            $('.btn_up').stop().animate({'opacity':0},function(){
               $(this).hide()
            });
        } else {
            $('.btn_up').stop().show().animate({'opacity':1});
        }

    });

//  script permettant d'activer un lien de menu : Jacques
    jQuery('#menu ul li').each(function() {

        var href = jQuery(this).find('a').attr('href');

        if (href === window.location.pathname) {
          jQuery('#accueil').removeClass('active');
          jQuery(this).addClass('active');
        }        
    });

    //Menu compte

    jQuery('.login-sign-in li').each(function() {

      var href = jQuery(this).find('a').attr('href');

      if (href === window.location.pathname) {
        jQuery('#accueil').removeClass('active');
        //
        jQuery('#inscr').removeClass('insactive');
        //jQuery(this).addClass('insactive').css("background" : "url('/img/menu-hover.jpg') center bottom no-repeat","background" : "url('/img/menu-hover.jpg') center bottom no-repeat");
          jQuery(this).addClass('insactive').css({
          "background": "url('/img/menu-hover.jpg') center bottom no-repeat",
          "text-decoration": "none"
        });
        jQuery(".insactive a").css({
          "color": "white"
        });
      }
    });

    //Menu niveau

    jQuery('#menu-niveau ul li').each(function() {

      var href = jQuery(this).find('a').attr('href');

      if (href === window.location.pathname) {
          jQuery(this).addClass('niveauactive');
      }
    });

// Code lié à l'inscription des élève
    // Bouton radio pack cours
    $('.formule-cours input:radio').click(function(){
        $('.formule-cours').css('background','#e5e5e5');
        $(this).parent().parent().css('background','white');
        $('.formule-pack').css('display','inline-block');
    });
    
    // Bouton radio pack cours déjà cliqué
    if($('.formule-cours [type=radio]:checked').prop("checked")){        
        $('.formule-cours [type=radio]:checked').parent().parent().css('background','white');            
        $('.formule-pack').css('display','inline-block');
    }
    
    //  Affichage des différents formulaire d'inscription élève
    $('.craue_poursuivre').click(function(){        
    //  On récupère le div de l'étape courant
        var parent = $(this).parents(".form-wrap-inner").parent(); 
    //  On récupère le div de l'étape suivant
        var next = parent.next();
    //  On vérifie si la personne est majeur sinon on affiche le formulaire parent
        if(parent.attr('id') == "step-2"){
            var date_de_naissance = $('#register_eleve_dateDeNaissance').val();
        //  On vérifie ici que le champ a bien été renseigné
            if(date_de_naissance){
            //  Le champ dete de naissance a été renseigné
                var firstValue = date_de_naissance.split('/');                
                
                var firstDate=new Date();
                firstDate.setFullYear(firstValue[2],(firstValue[1] - 1 ),firstValue[0]);
                var secondDate = new Date();
                
                var age = secondDate.getFullYear() - firstDate.getFullYear();
            //  Si la personne est majeur, on saute le formulaire parent
                if( age >= 18) next = next.next();
            }      
        }                
        next.show(3000);
    });

    /* Slider niveau */
     $( "#slider-blue" ).slider({
        orientation: "horizontal",
        range: "min",
        max: 160,
        value: 40,
        slide: slideSwatch,
        change: changeSwatch
    });
    $( "#slider-blue" ).slider( "value", 40 );
    //  Cette fonction agit quand on bouge le curseur
    function slideSwatch() {
        var niveau = $( "#slider-blue" ).slider( "value" );
        setClasse( $("#register_eleve_classe"), niveau );
    }
    //  Cette fonction agit quand on change la propriété value du slider
    function changeSwatch() {
        $( "#slider-blue" ).slider( "value" );        
    }
    // Ici on gère le niveau en fonction de la classe choisie
        //  On definie le niveau par defaut
    if($("#register_eleve_classe")){
        //  On recupère la classe
        var _classe =  $("#register_eleve_classe").val();
    //  On affiche le niveau
        setNiveau($( "#slider-blue" ), _classe); 
    }
        //  Si la classe change, on change aussi le niveau
    $("#register_eleve_classe").change(function(){    
    //  On recupère la classe
        var _classe =  $("#register_eleve_classe").val();
    //  On affiche le niveau
        setNiveau($( "#slider-blue" ), _classe);        
    });
});

/*
* 
* name: movTo
* description: permet de faire défiler les images du slider
* @returns [null]
* 
*/
function movTo( total, width ){        
//  On anime le slider
    jQuery('.slider-handler').animate({"left": '-'+( current_slide * width )}, { duration: 500} );
//  On gère la flêche dans bas de nos méthdodes
    jQuery('.content div').removeClass('active');
    jQuery('.content div').eq(current_slide).addClass('active');
//  On indique la prochaine etape
    current_slide +=1;    
    if( current_slide === ( total ) ){
        current_slide = 0;
    }    
}

/*
* 
* name: set_display_projets
* description: permet de faire défiler les vignettes des projets
* @returns [null]
* 
*/
function set_display_projets(container, first, last, method) {
    if(method === 'next'){
        container.children().eq(first-1).hide('slow');
        container.children().eq(last).show('slow');
    }else{
        container.children().eq(last+1).hide('slow');
        container.children().eq(first).show('slow');
    }
}

/*
 * Description: Vérifie si une variable existe dans un tableau
 * 
 * array array contient  une liste de variables
 * p_val string contient la variable à recherché
 */
function inArray(array, p_val) {
    var l = array.length;
    for(var i = 0; i < l; i++) {
        if(array[i] == p_val) {
            return true;
        }
    }
    return false;
}

/*
 * Description: Affiche le niveau de l'utilisateur courant
 * 
 * $container contient  l'objet slider
 * classe contient le choix de la classe courante
 */
function setNiveau($container, classe) {
    if(!classe) classe = "classe";
    var _primaire = ["classe", 1];        
    var _college = [2, 3, 4, 5];
    var _lycee = [6, 7, 8];
    var _universite = [9, 10];
    var niveau;
    if( inArray( _primaire, classe )  ){
        niveau = 1;
    }
    if( inArray( _college, classe )  ){
        niveau = 2;
    }
    if( inArray( _lycee, classe )  ){
        niveau = 3;
    }
    if( inArray( _universite, classe )  ){
        niveau = 4;
    }    
    $container.slider( "value", 40 * niveau );
}

/*
 * Description: Affiche la classe en fonction du niveau
 * 
 * $container contient  l'objet jquery de la classe
 * niveau contient le niveau en cours
 */
function setClasse($container, niveau) {
    var classe = parseInt(niveau/16);
    if( classe == 0) classe ="";
    if( niveau > 150 ) classe = 10;    
    
    $container.val( classe );
}