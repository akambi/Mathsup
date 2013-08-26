// Variable de départ pour le slider principal
var current_slide = 0;
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
        slider_handler.animate({"left": '-'+( current_slide * slider_width )}, { duration: 500} );
        slidetimer=setInterval("movTo(" + slider_content_length + "," + slider_width + ")", 5000);
    };

    $('<img class="precedent" />')
            .attr('src', '/img/slider-left.jpg')                
            .click( precedentAction )
            .insertBefore( '#slider' );

    $('<img class="suivant" />')
            .attr('src', '/img/slider-right.jpg')
            .click( suivantAction )
            .insertAfter( '#slider' );

    var slidetimer=setInterval("movTo(" + slider_content_length + "," + slider_width + ")", 5000);
/*  Fin du code du slider en haut de page */

/*  Action sur le formulaire d'inscription  */
    $("#fos_user_registration_form_roles_0").change(function(){
        var role = $("#fos_user_registration_form_roles_0").val();
        if( role == "ROLE_ELEVE" ){                       
            $('#fos_user_registration_form_classe').parent().show();            
        }else{                        
            $('#fos_user_registration_form_classe').parent().hide();
        }
    });

//  Ajout de la numérotation des titres des articles de la catégorie niveau
    $(".niveau #tabs article").each( function( ){
        $(this)
                .children()
                .find('h2')
                .each( function( index ){
                    $(this).text((index + 1)+". "+ $(this).text()); 
                });
    });
//  On gère ici le hover sur le bouton connexion
    $(".login-sign-in li a#member-connect").mouseenter( function( ){
        $("#menu-niveau").hide();
        $(".container-fluid > section > header").hide();
        $("#connexion-menu").show();
    });

    $(".container-fluid > section, .login-sign-in li:first a, #menu").mouseenter( function( ){
        $("#menu-niveau").show();
        $(".container-fluid > section > header").show();
        $("#connexion-menu").hide();
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
    $('.formule-cours input:radio').click(function(){
        $('.formule-cours').css('background','#e5e5e5');
        $(this).parent().parent().css('background','white');
        $('.formule-pack').css('display','inline-block');
    });

    $('.craue_poursuivre').click(function(){
        //alert(this.tagName);
        var parent = $(this).parents(".form-wrap-inner").parent();            
        var next = parent.next();
        parent.hide(3000);
        next.show(3000);        
    });

    /* Slider niveau */
     $( "#slider-blue" ).slider({
        orientation: "horizontal",
        range: "min",
        max: 160,
        value: 40,
        slide: refreshSwatch,
        change: refreshSwatch
    });
    $( "#slider-blue" ).slider( "value", 40 );
     function refreshSwatch() {
        $( "#slider-blue" ).slider( "value" );       
    }
});

/*
* 
* name: movTo
* description: permet de faire défiler les images du slider
* @returns [null]
* 
*/
function movTo( total, width ){        
    jQuery('.slider-handler').animate({"left": '-'+( current_slide * width )}, { duration: 500} );
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