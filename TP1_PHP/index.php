<?php
require 'fonctions.php';    

    start_page("Test");
    ?>
    <hr/><br/><b>Test</b><br/><hr/>
    
    <?php
    //echo date('l F d, Y');
    
    //$jour = date('l F d, Y');
    //echo $jour;
    $jour = date('d/m/Y', strtotime('2020-04-01'));
    
    //echo strtotime('2020-04-01');  //Cette fonction renvoie le timestamp
    //echo $jour;
    echo date('F d, Y , h:i A');
    
    end_page_page();
