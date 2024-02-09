
var date_actuelle = new Date(); // on récupère la date actuelle
var date_evenement = new Date("Feb 9 20:30:00 2024"); // on défini la date de l'événement

var total_secondes = (date_evenement - date_actuelle) / 1000; // en milliseconds de base dc / 1000 pour second


function mise_a_jour_compte_a_rebours() { //mise_a_jour_compte_a_rebours est une fonction qui met à jour le contenu de l'élément avec l'id compte_a_rebours
    var compte_a_rebours = document.getElementById('compte_a_rebours'); //compte_a_rebours cible l'élément avec l'id compte_a_rebours
    if (total_secondes > 0) {    //si le compte à rebours n'est pas terminé,on définit jours , heures , minutes et secondes  
        var jours = Math.floor(total_secondes / (60 * 60 * 24)); // Math.floor qui arrondit à l'entier inférieur le nombre donné,
        var heures = Math.floor((total_secondes - (jours * 60 * 60 * 24)) / (60 * 60));
        var minutes = Math.floor((total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60))) / 60);
        var secondes = Math.floor(total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60 + minutes * 60)));

        if (jours > 0) {  // si le nombre de jours est supérieur à 0
            compte_a_rebours.style.display = 'none'; // alors on met la div avec l'id compte_a_rebours en display_none
        } else { // sinon , on affiche le prefixe avec nombre d'heures, minutes et secondes
            compte_a_rebours.innerHTML = "Évènement dans " + heures + ' heures ' + minutes + ' minutes et ' + secondes + ' secondes.';
        }
        total_secondes--;   //decrementer le nombre de secondes
    } else { // si timer inf à 0, évenement est terminé 
        compte_a_rebours.innerText = "Évènement terminé ";
    }
}
//On crée un intervalle qui va se répéter toutes les secondes, et qui va mettre à jour le contenu 
var actualisation = setInterval(mise_a_jour_compte_a_rebours, 1000);
