
<?php


function affiche($tab) {
            foreach($tab as $key=>$value) {
                if (isset($value)) {
                    echo "$key=>$value <br/>";
                        if (is_array($value))
                            affiche($value);
                }
             }
             echo "<br/>";
        }
        
function db_lire_ligne($requete) {
    //La variable $ok est utilisée pour savoir si tout se passe bien
    //se connecter et selectionner la base
    $ok = ($connexion = mysqli_connect('localhost','root','root'));
    //On teste si l'objet connexion existe
    if ($ok) {
        $ok= mysqli_select_db($connexion,'TEST_PHP');
    }
    //Executer la requete et tester le resultat pour affecter la variable $ok
    if ($ok) {
        $ok = (($resultat = mysqli_query($connexion,$requete)) != FALSE);
    }
    //Lire ligne
    if ($ok) {
        $ligne = mysqli_fetch_assoc($resultat);
    }
    //Retourner $ligne ou false en cas d'erreur
    
    return ($ok)?$ligne:FALSE;

}

function db_read_all_line($requete) {
    //La variable $ok est utilisée pour savoir si tout se passe bien
    //se connecter et selectionner la base
    $ok = ($connexion = mysqli_connect('localhost','root','root'));
    //On teste si l'objet connexion existe
    if ($ok) {
        $ok= mysqli_select_db($connexion,'TEST_PHP'); echo "connexionSelectionOK <br/>";
    }
    //Executer la requete et tester le resultat pour affecter la variable $ok
    if ($ok) {
        $ok = ( ($resultat = mysqli_query($connexion,$requete)) != FALSE);
    }
    //si la requete renvoie un resultat
    if ($ok) {
        echo '<br/><br/>';
        while($x = mysqli_fetch_assoc($resultat)) {
            $tableau[] = $x;
        }
        
    }
    
    return ($ok)?$tableau:FALSE;
}


?>