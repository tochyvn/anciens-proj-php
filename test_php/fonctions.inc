
<?php function affiche($tab) {
            foreach($tab as $key=>$value) {
                if (isset($value)) {
                    
                        if (is_array($value))
                            affiche($value);
                        else
                            echo "$key=>$value <br/>";
                }
            }
            echo "<br/>";
        }  
?>