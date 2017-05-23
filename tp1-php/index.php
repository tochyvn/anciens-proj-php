<?php
$ages = array(5,6,7,9,10,11,12,13,14,15,16,17,18,19,20);

function sendData() {
    return isset($_REQUEST['envoyer']);
    }
    
function lesLabels($for,$value) {
    $tab = [$for => $value];
    return $tab;
}

function lesInputs($type,$value) {
    
}
//balise<form>
echo "<form method=\"post\" action=\"script.php\>";

echo "Nom: <input type=\"text\" name=\"nom\"><br/>";
echo "Age: <select name=\"age\"



echo "</form>";


?>