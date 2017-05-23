<?php
$form_nom="mon nom est".$_POST['nom'];
$form_prenom="mon prenom est".$_POST['prenom'];
?>

<!DOCTYPE html>

<html>
<head>
    <title>Saisie</title>
</head>

<body>
    <form action="" method="post">
        <div>
            Nom : <input type="text" name="nom" value="<?php echo $form_nom ?>" /><br/><br/>
            prenom : <input type="text" name="prenom" value="<?php echo $form_prenom ?>" /><br/><br/>
            <input type="submit" name="ok" value="ok" />
        </div>
    </form>
    <br/><br/>
    <form action="" method="post">
        <div>
            Nom : <input type="number" name="nom" value="<?php echo $form_nom ?>" /><br/><br/>
            <input type="submit" name="ok" value="ok" />
        </div>
    </form>
<br/><br/><br/>
<?php foreach($_POST as $key=>$value) {
    echo "$key=>$value <br/>" ;
    }?>
    
    <!--REMARQUES: LORSQU'ON A PLUSIEURS FORMULAIRES ET QUE L'ON CLIQUE SUR LE PREMIER ENSUITE SUR LE DEUXIEME,
    LES DONNEES DU PREMIER SONT EFFACƒ DU TABLEAU $_POST AVANT D'INSERER LES DONNEES DU SECOND CLIC --> 

</body>
</html>