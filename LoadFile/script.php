<?php
    $tmpFileName=$_FILES['monFichier']['tmp_name'];
    $name = $_FILES['monFichier']['name'];
    var_dump($name);
    var_dump($tmpFileName);
    //--------------------------------------------------------------
    //---------- On copie l'image dans le repertoir upload----------
    
    
    mkdir('files/file0');
    $dest='files/file0/'.$name;
    var_dump(move_uploaded_file($tmpFileName, $dest));
    $_FILES['fichier']['error'];
    
 