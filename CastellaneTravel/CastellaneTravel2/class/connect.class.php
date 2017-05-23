<?php

class connect {
    //put your code here
    // attribut
    
    private $DB;
    
    public function __construct($DB){
        
        if(!isset($_SESSION['user'])){
            $_SESSION['user'] = array();
        }
        $this->DB = $DB;
    }

    public function login($email, $passwd) {
        $sql = "SELECT * FROM utilisateur "
            . "WHERE adrMailUtilisateur ='".$email."'";
    
        $stmt = $this->DB->queryOne($sql);
        //foreach($stmt as $stm):
           $pswd = $stmt->mdpUtilisateur;
        //endforeach;
            if ($pswd) {
                if ($pswd == $passwd) {
                   // session_start();
                    $_SESSION['user']=$stmt->idUtilisateur;
                    var_dump($_SESSION['user']);
                    var_dump($stmt->idUtilisateur);
                    return array(
                        'connected' => TRUE,
                        'code' => 0,
                        'msg' => 'Vous êtes bien connectez',
                        //'informations' => $row
                    );
                }
                return array(
                    'connected' => FALSE,
                    'code' => 2,
                    'msg' => 'Le mot de passe que vous avez rentré n\'est pas valide'
                );
            }
        return array(
            'connected' => FALSE,
            'msg' => 'Cet utilisateur n\'existe pas dans la base de données',
            'code' => 1
        );
    }
    
    public function  deconnect() {
        unset($_SESSION['user']);
    }
    
}