<?php 
require '../class/db.class.php';
require '../class/panier.class.php';
//require '../class/connect.class.php';
$DB = new DB();
$panier = new panier($DB);
//$user = new connect();


$ids = array_keys($_SESSION['panier']);
if(empty($ids)){
    $commandes=array();
} else {
    $commandes = $DB->query('SELECT * FROM produit WHERE idProduit IN ('.implode(',',$ids).')') ;
}
foreach($commandes as $product):
    echo $product->nomProduitFR .'- nomProd -' ;
    echo $product->prixProduit .'- PrixProd -' ;
    echo $_SESSION['panier'][$product->idProduit] .'- Qt -' ;
    echo $product->idProduit .'- id ';
endforeach;

$temp = array();
$total=0;
foreach($commandes as $product):
    $test= array( 
    "name" => $product->nomProduitFR,
    "price" => $product->prixProduit,
    "priceTVA" => $product->prixProduit * 1.2,
    "count"=> $_SESSION['panier'][$product->idProduit]
    );
    $CommFinal = array($temp,$test);
    $temp = $test;
    $total += $test['priceTVA']*$_SESSION['panier'][$product->idProduit] ;
endforeach;

var_dump($product);
var_dump($commandes);
var_dump($CommFinal);
var_dump($total);


require 'Paypal.php';

$products = $CommFinal;
$totalttc = $total;

$paypal = new Paypal();
$params = array(
    'RETURNURL' => 'http://localhost/CastellaneTravel/paypal/returnurl.php',
    'CANCELURL' => 'http://localhost/CastellaneTravel/page/panier.php',
    
    
    'PAYMENTREQUEST_0_AMT' => $totalttc,
    'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
    'PAYMENTREQUEST_0_ITEMAMT' => $totalttc,
//    'PAYMENTREQUEST_0_SHIPPINGAMT' => 10.0 //frais de port pas obli
);
foreach ($products as $k => $product){
    $params["L_PAYMENTREQUEST_0_NAME$k"] = $product['name'];
    $params["L_PAYMENTREQUEST_0_DESC$k"] = ''; // a remplacer par la descrip du tableau.
    $params["L_PAYMENTREQUEST_0_AMT$k"] = $product['priceTVA']; //prix
    $params["L_PAYMENTREQUEST_0_QTY$k"] = $product['count'];
}

$response = $paypal->request('SetExpressCheckout', $params);

if($response){
    var_dump('https://www.sandbox.paypal.com/websrc?cmd=_express-checkout&useraction=commit&token='.$response['TOKEN']);
    //a mettresur le lien du bouton payer
    $paypal = 'https://www.sandbox.paypal.com/websrc?cmd=_express-checkout&useraction=commit&token='.$response['TOKEN'];
}else{
    var_dump($paypal->errors);
    die('Erreur');
}


