<?php 

if (isset($_POST['numA']) && isset($_POST['numB'])) {
    $numA = $_POST['numA'];
    $numB = $_POST['numB'];
    $somme = $numA + $numB;
    
    echo 'La somme de '.$numA.' et de '.$numB.' est '.$somme;
}
else {
    echo 'vous n\'avez rien rentré dans le formulaire';
}
