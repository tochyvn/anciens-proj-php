<!DOCTYPE html>
<html>
    <head>
        <meta charset=UTF-8/>
        <title>Codes d'acc&agrave;s � la centrale</title>
    </head>
    <body>
        
        <?php

            //On verifie le password
            if(isset($_POST['passwd']) and $_POST['passwd'] == "Kangourou") {
        ?>
                <h1>Voici les codes d'acc�s :</h1>
                <p><strong>CRD5-GTFT-CK65-JOPM-V29N-24G1-HH28-LLFV</strong></p>   
        
                <p>
                    Cette page est r�serv�e au personnel de la NASA. N'oubliez pas de la visiter r�guli�rement car les codes d'acc�s sont chang�s toutes les semaines.<br />
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

