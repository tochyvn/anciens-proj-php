<?php

/* 
 * Ce scripte va recuperer les informations du composant
 * et les retourner à la vue
 */


//----- Classe de chargement  ---------
require 'controleur'.DIRECTORY_SEPARATOR.'Autoload.php';
spl_autoload_register('charge');

//---- Ce morceau de code va recuperer les propriétés de l'élement
//------ selectionné et les retourner à la vue ----------
if(isset($_POST['ido'])){
    $pro=Manager::getManager()->getSommetByName($_POST['ido']);
    echo $pro['Description'].",".$pro['Etat'].",".$pro['ID'].",".$pro['Nombre entrées'].",".$pro['Nombre sorties'];
}

//--- Ce morceau de code va créer l'objet correspondant au composant rajouté
//---- dans la zone de conception ----
if(isset($_POST['new'])){
    $tmp=substr($_POST['new'], 0, strlen($_POST['new'])-1);
    $prop=explode(";", $tmp);
    //print_r($prop);
    $tab=[];
    foreach ($prop as $val) {
        $split_prp=  explode(",", $val);
        //print_r($split_prp);
        $tab[]=Array('name'=>$split_prp[0],
               'id'=>$split_prp[1],
               'src'=>$split_prp[2],
               'code'=>$split_prp[3],
               'top'=>$split_prp[4],
               'left'=>$split_prp[5],
               'lien'=>$split_prp[6]);
    }
    
    echo Manager::getManager()->newSommet($tab);
}
if(isset($_POST['link'])){
    $tmp=  explode(",", $_POST['link']);
    //print_r($tmp);
    $tab=Array('sommet'=>$tmp[0],
               'lien'=>$tmp[1]);
    //echo $tab['lien'];
    echo Manager::getManager()->newLink($tab);
}
//--- Si une simulation est encours ---
if(isset($_POST['sim'])){
    $tmp=substr($_POST['sim'], 0, strlen($_POST['sim'])-2);
    $prop=explode(";", $tmp);
    //print_r($prop);
    $tab=[];
    foreach ($prop as $val) {
        $split_prp=  explode(",", $val);
        $t=[];
        $t['name']=$split_prp[0];
        $t['id']=$split_prp[1];
        $t['lien']=$split_prp[2];
        if(count($split_prp)>=4){
            if(count($split_prp)===4){
                if($split_prp[0]==='INTER')$t['s']=$split_prp[3];//echo $t['s'];}
                if($split_prp[0]==='LAMPE')$t['e1']=$split_prp[3];
                
            }elseif(count($split_prp)===5){
                $t['e1']=$split_prp[3];
                $t['s']=$split_prp[4];
                //echo $t['s'];
            }else{
               $t['e1']=$split_prp[3];
               $t['e2']=$split_prp[4];
               $t['s']=$split_prp[5];
               //echo $t['s'];
            }
            
        }
        $tab[]=$t;
        //echo $split_prp['name'];
    }
    //print_r($tab);
    echo Manager::getManager()->createSimule($tab);
}





