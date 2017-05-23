<!DOCTYPE html>

<html>
<head>
    <title>TEST1</title>
</head>

<body>
    <form action="test1.php" method="post">
        <div>
            Nom : <input type="text" name="saisie[nom]" /><br/><br/>
            Prenom : <input type="text" name="saisie[prenom]" /><br/><br/>
            <input type="submit" name="ok" value="ok" /><br/><br/>
            <?php affiche($_POST);
            ?>
            <?php function affiche($tab) {
                foreach($tab as $key=>$value) {
                    if (isset($value))
                        echo "$key=>$value <br/>";
                    if (is_array($value))
                        affiche($value);
                }
            }
            ?>
            <br/><br/>
            <?php $tableau=[1,2,3,["a","b","c"]];
                affiche($tableau);
            ?>
        </div>
        
    </form>

</body>
</html>