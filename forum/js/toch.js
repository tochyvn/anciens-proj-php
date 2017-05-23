//Fonction pour desactiver l'affichage des erreurs javascript
function desactivateerror_jss() {
    var error_jss = document.querySelectorAll('.error_js'),
        error_jssLength = error_jss.length;
    
    for (var i = 0; i < error_jssLength; i++) {
        error_jss[i].style.display = 'none';
    }
    
}

/**
 * Function permettant de recuperer le error_js qui correspond à notre input
 * @param {type} elements represente l'input dont on veut recupérer la zone d'affichage d'erreur correspondante (error_js)
 * @returns {elements.nextSibling|Boolean} retourne le error_js
 */
function geterror_js(elements) {

    while (elements = elements.nextSibling) {
        if (elements.className === 'error_js') {
            console.log(elements.className);
            return elements;
        }
    }

    return false;

}

//Declenchée lorsque le Dom a fini de se charger
function pageLoaded() {
    // Mise en place des événements
    (function() { // Utilisation d'une IIFE pour éviter les variables globales.
        
        var inputs_connexion = document.querySelectorAll('#form_connexion input[type=text], #form_connexion input[type=password]'),
            inputsLength = inputs_connexion.length;
            
        for (var i = 0; i < inputsLength; i++) {
            inputs_connexion[i].addEventListener('blur', function(e) {
                check_connexion[e.target.id](e.target.id); // "e.target" représente l'input actuellement modifié
            }, false);
            inputs_connexion[i].addEventListener('keyup', function(e) {
                check_connexion[e.target.id](e.target.id); // "e.target" représente l'input actuellement modifié
            }, false);
        }
        
        var inputs_inscription = document.querySelectorAll('#form_inscription input[type=text], #form_inscription input[type=password]'),
            inputsLength = inputs_inscription.length;
            console.log(inputsLength);
        for (var i = 0; i < inputsLength; i++) {
            inputs_inscription[i].addEventListener('blur', function(e) {
                check_inscription[e.target.id](e.target.id); // "e.target" représente l'input actuellement modifié
            }, false);
            inputs_inscription[i].addEventListener('keyup', function(e) {
                check_inscription[e.target.id](e.target.id); // "e.target" représente l'input actuellement modifié
            }, false);
        }

        var input_update_email = document.getElementById('mail_modal');
        input_update_email.addEventListener('blur', function(e) {
            console.log('tochap');
            check_update['mail_modal']('mail_modal');
        });
        input_update_email.addEventListener('keyup', function(e) {
            console.log('tochap');
            check_update['mail_modal']('mail_modal');
        });

    })();
    desactivateerror_jss();
}

//Fonctions de verification des formulaire
var check_connexion = {};

check_connexion['mail'] = function(id) {
    var name = document.getElementById(id),
        error_jsStyle = geterror_js(name).style,
        regexp = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;

    if (!regexp.test(name.value)) {
        console.log(error_jsStyle);
        name.className = 'incorrect form-control';
        error_jsStyle.display = 'block';
        console.log(error_jsStyle);
        return false;
    } else {
        name.className = 'correct form-control';
        error_jsStyle.display = 'none';
        return true;
    }
};

check_connexion['password'] = function(id) {

    var pwd1 = document.getElementById(id),
        error_jsStyle = geterror_js(pwd1).style;

    if (pwd1.value.length >= 6) {
        pwd1.className = 'correct form-control';
        error_jsStyle.display = 'none';
        return true;
    } else {
        pwd1.className = 'incorrect form-control';
        error_jsStyle.display = 'inline-block';
        return false;
    }

};

var check_inscription = {};

check_inscription['nom'] = function(id) {
    var nom = document.getElementById(id),
    error_jsStyle = geterror_js(nom).style;
    if (nom.value.length > 0) {
        nom.className = 'correct form-control';
        error_jsStyle.display = 'none';
        return true; 
    } else {
        nom.className = 'incorrect form-control';
        error_jsStyle.display = 'inline-block';
    }
};

check_inscription['prenom'] = check_inscription['nom'];
check_inscription['pseudo'] = check_inscription['nom'];
check_inscription['mail1'] = check_connexion['mail'];
check_inscription['password1'] = check_connexion['password'];


check_inscription['password1_conf'] = function() {
    var pwd1 = document.getElementById('password1'),
        pwd2 = document.getElementById('password1_conf'),
        error_jsStyle = geterror_js(pwd2).style;

    if (pwd1.value === pwd2.value && pwd2.value !== '') {
        pwd2.className = 'correct  form-control';
        error_jsStyle.display = 'none';
        return true;
    } else {
        pwd2.className = 'incorrect form-control';
        error_jsStyle.display = 'inline-block';
        return false;
    }

};

var check_update = {}
check_update['mail_modal'] = check_connexion['mail'];


window.onload = pageLoaded;





