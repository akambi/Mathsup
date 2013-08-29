//  On récupère les elements par leur id
    var qcm_time = document.getElementById("qcm_time");
    var question_time = document.getElementById("question_time");
    var form_time = document.getElementById("time");
    var quest_form = document.getElementById("quest_form");
//  on recupere les temps
    var time_globale = qcm_time.innerHTML;
    var time_locale = question_time.innerHTML;        
//  La fonction qui gère le décompte
    function Rebour() {
    //  on décrémente les secondes de 1
        time_globale = time_globale - 1;
        time_locale = time_locale - 1;
        time = time - 1;
    if( time_globale >= 0 && time_locale >= 0 ){
    //  On définie la minutete, l'heure et la seconde locale et globale
        h_g = Math.floor ( time_globale / 3600 );
        h_l = Math.floor ( time_locale / 3600 );

        mn_g = Math.floor ( time_globale / 60 );
        mn_l = Math.floor ( time_locale / 60 );

        sec_g = Math.floor ( time_globale - (( h_g * 3600 + mn_g * 60)));
        sec_l = Math.floor ( time_locale - (( h_l * 3600 + mn_l * 60)) );
    //  On affiche l'heure
        qcm_time.innerHTML = "" + h_g +" h "+ mn_g +" min "+ sec_g + " s ";
        question_time.innerHTML = "" + h_l +" h "+ mn_l +" min "+ sec_l + " s ";
        form_time.value = time_globale;
    }else{        
        if( time_locale <= 0 ){
        //  Si le temps de la question est fini, on soumet le formulaire
            quest_form.submit();
        }else{
        //  Si le temps du qcm est fini, on soumet le formulaire et on va à la fin du qcm
            var action = quest_form.action;
            var array_action = action.split('/');        
            array_action[ array_action.length - 2] = "end";
            var new_action = "";
            for( var i = 0; i < ( array_action.length - 1 ); i++){
                new_action += array_action[i] + '/';
            }            
            quest_form.action = new_action;
            quest_form.submit();
        }
    }
    //  on relance le compte à rebours chaque seconde
        tRebour=setTimeout ("Rebour();", 1000);

    }
//  Lancer le compte à rebour
    Rebour();