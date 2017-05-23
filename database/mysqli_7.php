<?php
//On inclut notre bibliotheque de fonctions
include('fonctions.inc');
//La requete necessaire pour l'extraction
$requete = 'SELECT * FROM ARTICLES';
$fruits = db_read_all_line($requete);
//affiche($fruits);
?>

<! DOCTYPE html>
    <html>
        <head>
            <title>LISTE DES ARTICLES</title>
        </head>
        <body>
            <div>
                <form action="mysqli_7.php" method="post"><br/>Recuperation dans une bd<br/>
                    <select name="fruits[]" multiple="multiple" size="8" >
                        <?php
                            foreach($fruits as $fruit) {
                                echo "<option value=\"{$fruit['identifiant']}\" >{$fruit['libelle']}<option/>";
                            }
                        ?>
                    </select>
                    <input type="submit" name="ok" value="ok" />
                </form>
            </div>
        </body>
    </html>
    