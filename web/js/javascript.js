$(document).ready(function() {    
    $("#fos_user_registration_form_roles_0").change(function(){
        var role = $("#fos_user_registration_form_roles_0").val();
        if( role == "ROLE_ELEVE" ){                       
            $('#fos_user_registration_form_classe').parent().show();            
        }else{                        
            $('#fos_user_registration_form_classe').parent().hide();
        }
    });
});