<!DOCTYPE html>
<html>
    <head>
        <meta charset=UTF-8/>
        <title>Codes d'acc&agrave;s à la centrale</title>
    </head>
    <body>
        
        <?php

            //On verifie le password
            if(isset($_POST['passwd']) and $_POST['passwd'] == "Kangourou") {
        ?>
                <h1>Voici les codes d'accès :</h1>
                <p><strong>CRD5-GTFT-CK65-JOPM-V29N-24G1-HH28-LLFV</strong></p>   
        
                <p>
                    Cette page est réservée au personnel de la NASA. N'oubliez pas de la visiter régulièrement car les codes d'accès sont changés toutes les semaines.<br />
                     La NASA vous remercie de votre visite.
                </p>
            <?php
            }
            
            else {
                
                    echo '<p>Password incorrect</p>';
                    
            }
            ?>
    </body>                                     
                                     
</html>

