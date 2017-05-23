<?php 
    require '../class/db.class.php';
    require '../class/panier.class.php';
    $DB = new DB();
    $panier = new panier($DB);
    $json= array('error' => true);
    if(isset($_GET['id'])){
        $product= $DB->query("SELECT * FROM produit WHERE idProduit=:id", array('id' => $_GET['id']));
        if(empty($product)){
            $json['message']="Ce produit n'existe pas";
        }
        //var_dump($product);
        $panier->add($product[0]->idProduit);
        $json['error']= false;
        $json['total'] = $panier->total();
        $json['count'] = $panier->count();
        $json['message']='prod ajoué panier';
    }else{
        die("pas de selection de prod");
    }
    echo json_encode($json);
    //var_dump($_GET);