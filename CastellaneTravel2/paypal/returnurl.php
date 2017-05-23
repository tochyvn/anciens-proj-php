<?php 

//if(!isset($_GET['token'])){
//    //redirection une page je sais pas laquelle
//}
require 'Paypal.php';
$paypal = new Paypal();
$response = $paypal->request('GetExpressCheckoutDetails', array(
    'TOKEN' => $_GET['token'],
));
if($response){
    if($response['CHECKOUTSTATUS'] == 'PaymentActionCompleted'){
        die('Ce paiement a déjà été validé');
    }
}else{
    var_dump($paypal->errors);
    die();
}

$response = $paypal->request('DoExpressCheckoutPayment', array(
    'TOKEN' => $_GET['token'],
    'PAYERID' => $_GET['PayerID'],
    'PAYMENTACTION' => 'Sale',
    'PAYMENTREQUEST_0_AMT' => $response['PAYMENTREQUEST_0_AMT'],
    'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR'
));
if($response){
    var_dump($response);
    $response['PAYMENTINFO_0_TRANSACTIONID'];
}else{
    var_dump($paypal->errors);
}
// a save PAYMENTINFO_0_TRANSACTIONID en bdd
?>

