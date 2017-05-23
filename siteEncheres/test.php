<?php

/*try{


//$list=AuthorQuery::create()->filterByFirstName("toto")->filterByLastName('titi')->find();
$a->save();
}
catch (Exception $e){
    echo $e;  
}*/
try {
    $pack = new Packjeton();
    $pack->setJetons(5);
    $pack->save();
    echo $pack;
    
}catch(PDOException $e) {
    echo $e->getMessage();
} 
