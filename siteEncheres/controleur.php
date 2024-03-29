<?php
use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;

session_start();
$actions = array("accueil" => 0,"connexion" => 0,"formulaire"=>0,
    "programEnchere" => 0,"ajoutArticle.php" => 0,"achatJetons" => 0,
    "deconnexion" => 0,"inscription" => 0);

try {
    spl_autoload_register(function ($class) {
                file_exists('xmlForm/' . $class . '.php') && require 'xmlForm/' . $class . '.php';
            });
    
    require_once 'vendor/autoload.php';

    $serviceContainer = Propel::getServiceContainer();
    $serviceContainer->setAdapterClass('SITE_ENCHERES', 'mysql');
    $manager = new ConnectionManagerSingle();
    $manager->setConfiguration(array(
        'dsn' => 'mysql:host=localhost;port=8889;dbname=SITE_ENCHERES',
        'user' => 'root',
        'password' => 'root',
    ));
    $serviceContainer->setConnectionManager('SITE_ENCHERES', $manager);

    require_once("vendor/twig/twig/lib/Twig/Autoloader.php");
    Twig_Autoloader::register();
    $loader = new Twig_Loader_Filesystem("templates");
    $twig = new Twig_Environment($loader, array("cache" => false));
    
    if (!array_key_exists($_GET['action'], $actions) || !isset($_SESSION['user']) && $actions[$_GET['action']] > 0 || isset($_SESSION['user']) && $actions[$_GET['action']] > $_SESSION['user']['role']) {
        $param['msg'] = "Action non reconnue ou droit insuffisant pour exécuter l'action...";
    } else {
        include('actions/' . $_GET['action'] . ".php");
        $tpl = $_GET['action'] . ".twig";
    }

    if (isset($_SESSION['user']))
        $param['user'] = $_SESSION['user'];
} catch (Exception $e) {
    $param['msg'] = $e->getMessage();
}
if (!isset($tpl))
    $tpl = 'erreur.twig';
if (!isset($param))
    $param = array();

try{
echo $twig->render($tpl, $param);
}
catch(Exception $e)
{
    echo "erreur de chargement de la vue $tpl";
}