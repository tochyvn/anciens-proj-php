//Memorisation de la reference de l'objet XMLHttpRequest
var xmlHttp = createXMLHttpRequestObject();

//Obtenir l'objet XMLHttpRequest
function createXMLHttpRequestObject() {
    //code
    var xmlHttp;
    //Si le navigateur est internet explorer 6 ou plus ancien
    if (window.ActiveXObject) {
        try {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch(e) {
            xmlHttp = false;
        }
    }else { //Si le navigateur est mozilla ou autre
        try {
            xmlHttp = new XMLHttpRequest();
            alert("Creation de l'objet XMLHttpRequest OK")
        } catch(e) {
            xmlHttp = false;
        }
    }
    
    //Retourner l'objet crée ou afficher une erreur.
    if (!xmlHttp) {
        alert("Erreur de creaion de l'objet XMLHttpRequest.")
    }else {
        return xmlHttp;
    }
}

//Effectuée une requete HTTP asynchrone en utilisant l'objet XMLHttpRequest.
function process() {
    
   //alert("IMANE JE t'aime");
    
    //On continue uniquement si l'objet xmlHttp est disponible
    if (xmlHttp.readyState==4 || xmlHttp.readyState==0) {
        //On recupere le nom saisie par l'utilisateur dans le formulaire
        name = encodeURIComponent(document.getElementById("myName").value);
        //On execute la page quickstart.php depuis le serveur ET ON ENVOIE CE NOM DANS L'URL
        xmlHttp.open("GET", "quickstart.php?name="+name+"", true);
        //Definir la methode pour traiter les reponses du serveur en s'appuyant sur le changement d'etat de xmlHttp
        //alert("Debut d'execution du onreadystatechange");
        xmlHttp.onreadystatechange = handleServerResponse;
        //alert("Fin d'execution du onreadystatechange")
        //Faire la demande au serveur
        xmlHttp.send(null);
    }else {
        //Si la connexion est indisponible, tenter à nouveau après 1 secondes
        setTimeout('process()',1000);
    }
}

    //Fonction de rappel executé automatiquement lorsqu'un message de rappel est reçu depuis le serveur
    function handleServerResponse() {
        //CONTINUER UNIQUEMENT SI LA TRANSACTION EST TERMINÉE
        //alert("etat: "+xmlHttp.readyState);
        if (xmlHttp.readyState==4 && xmlHttp.status==200) {
            //Extraire la reponse XML reçue du serveur
            xmlResponse = xmlHttp.responseXML;
            //Prendre l'élement document
            xmlDocumentElement = xmlResponse.documentElement;
            //Obtenir le texte du message, qui est dans le premier element enfant de l'element document
            helloMessage = xmlDocumentElement.firstChild.data;
            //Afficher les données reçues du serveur.
            document.getElementById("divMessage").innerHTML = '<em>'+helloMessage+'<emi>';
            
            //Reprendre la sequence
            setTimeout('process()', 1000);
        }else {
            //alert("Problème d'accès au serveur : "+xmlHttp.statusText+" "+xmlHttp.readyState);
        }
    }