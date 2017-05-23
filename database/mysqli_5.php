<?php
//phpinfo();
include('fonctions.inc');
//AFFICHER LA LISTE DES ARTICLES DANS UN TABLEAU HTML
//variable $message
$message="";
//connexion
$ok = ($connexion = mysqli_connect('localhost','root','root'));
if ($ok) {
    $message.="Connexion reussie"; echo $message,'<br/>';
    $ok = mysqli_select_db($connexion,'TEST_PHP');
    if ($ok) {
        $message = "Selection OK"; echo $message.'<br/>';
        $sql = "SELECT * FROM ARTICLES";
        $resultat = mysqli_query($connexion,$sql);
        
    }
}

?>
<!DOCTYPE html>

<html>
<head>
    <title>Page Title</title>
    <style>
        .toch {
            border: solid 1px blue;
        }
    </style>
</head>

<body>
    <br/><br/>
<form action="mysqli_5.php" method="post">
<table class="toch">
    <thead>
        <th>LIBELLE</th>
        <th>PRIX</th>
        <th>CASE</th>
        <th>LIEN</th>
    </thead>
<?php
while ($article=mysqli_fetch_assoc($resultat)) {   
    printf('<tbody>
        <tr>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
        </tr>
    </tbody>',$article['libelle'],number_format($article['prix'],2,',',' '),"<input type=\"checkbox\" name=\"choix[]\" value=\"{$article['identifiant']}\" />","<a href=\"javascript:alert({$article['identifiant']})\">action<a>");
    
}//FIN while
?>
</table>

<p> <input type="submit" name="ok" value="ok" /></p>

</form>

<?php
//affiche($_POST['choix']);
    if (isset($_POST['ok'])) {
        if (isset($_POST['choix'])) {
            echo "Les identifiants coch&eacutes : ".implode(', ',$_POST['choix']);
        }
    }
?>


</body>
</html>