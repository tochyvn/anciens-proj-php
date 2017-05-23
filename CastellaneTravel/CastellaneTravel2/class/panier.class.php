<?php
class panier{
    
    private $DB;
    
    public function __construct($DB){
        if(!isset($_SESSION)){
            session_start();
        }
        if(!isset($_SESSION['panier'])){
            $_SESSION['panier'] = array();
        }
        $this->DB = $DB;
        
        if(isset($_POST['panier']['quantity'])){
            $this->recalc();
        }
    }

    public function add($product_id){
        if(isset($_SESSION['panier'][$product_id])){
            $_SESSION['panier'][$product_id] ++ ;
        } else{
            $_SESSION['panier'][$product_id] = 1 ;
        }
    }
    
    public function del($product_id){
        unset($_SESSION['panier'][$product_id]);
    }
    
    public function total(){
        $total=0;
        $ids = array_keys($_SESSION['panier']);
        if(empty($ids)){
            $products=array();
        } else {
            $products = $this->DB->query('SELECT * FROM produit WHERE idProduit IN ('.implode(',',$ids).')') ;
        }
        foreach($products as $product){
            
            $total += $product->prixProduit * $_SESSION['panier'][$product->idProduit];
        }
        return $total;
    }
    
    public function count(){
        return array_sum($_SESSION['panier']);
    }
    
    public function recalc(){
        foreach( $_SESSION['panier'] as $product_id=> $quantity){
            if(isset($_POST['panier']['quantity'][$product_id])){
                $_SESSION['panier'][$product_id] = $_POST['panier']['quantity'][$product_id];
            }
        }
    }
}