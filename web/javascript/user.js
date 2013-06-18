$(document).ready(function() {        
    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container_user_family = $('#msp_userbundle_usertype_userFamilies');
    
      // On ajoute un lien pour ajouter une nouvelle réponse
    var $lienAjout = $('<a href="#" title="Ajouter un parent" id="ajout_parent" class="btn"><i class=" icon-plus"></i></a>');
    $container_user_family.append($lienAjout);

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $lienAjout.click(function(e) {
      ajouterUserFamily($container_user_family);
      e.preventDefault(); // évite qu'un # apparaisse dans l'URL
      return false;
    });
    
    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container_user_family.find(':input').length;

    // On ajoute un premier champ directement s'il n'en existe pas déjà un (cas d'un nouvel article par exemple).
    if (index == 0) {
        for( var i = 0; i < 2; i++){
            ajouterUserFamily($container_user_family);
        }      
    } else {
      // Pour chaque catégorie déjà existante, on ajoute un lien de suppression
      $container_user_family.children('div').each(function() {
        ajouterLienSuppression($(this));
      });
    }

    // La fonction qui ajoute un formulaire Categorie
    function ajouterUserFamily($container_user_family) {
      // Dans le contenu de l'attribut « data-prototype », on remplace :
      // - le texte "__name__label__" qu'il contient par le label du champ
      // - le texte "__name__" qu'il contient par le numéro du champ
      var $prototype = $($container_user_family.attr('data-prototype').replace(/__name__label__/g, 'Parent n°' + (index+1))
                                                          .replace(/__name__/g, index));

      // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
      ajouterLienSuppression($prototype);

      // On ajoute le prototype modifié à la fin de la balise <div>
      $container_user_family.append($prototype);

      // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
      index++;
    }

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function ajouterLienSuppression($prototype) {
      // Création du lien
      $lienSuppression = $('<a title="Supprimer" href="#" class="btn btn-danger"><i class="icon-remove"></i></a>');

      // Ajout du lien
      $prototype.append($lienSuppression);

      // Ajout du listener sur le clic du lien
      $lienSuppression.click(function(e) {
        $prototype.remove();
        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
      });
    }
});