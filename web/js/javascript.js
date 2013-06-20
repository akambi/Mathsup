// Variable de départ pour le slider principal
var current_slide = 0;

$(document).ready(function() {    
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