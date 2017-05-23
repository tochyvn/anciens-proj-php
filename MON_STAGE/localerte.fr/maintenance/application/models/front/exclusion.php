<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of exclusion
 *
 * @author Guillaume
 */
class exclusion extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function getExclusion($chaine, $annonce){
        
        $query=array();
        for( $i=0 ; $i <sizeof($annonce) ; $i++ ){
            $query[] = 'find_in_set(\''.$annonce[$i].'\',annonce)>0';
        }
                        
        $sql = '
                SELECT COUNT(identifiant) as nombre
                FROM exclusion
                WHERE
                        (
                            negatif=\'NON\'
                            and casse=\'INSENSIBLE\'
                            and \''.addslashes($chaine).'\' rlike expression
                            '.((sizeof($query))?('and ('.implode(' or ',$query).')'):('and 0')).'
                        )
                        or
                        (
                            negatif=\'OUI\'
                            and casse=\'INSENSIBLE\'
                            and \''.addslashes($chaine).'\' not rlike expression
                            '.((sizeof($query))?('and ('.implode(' or ',$query).')'):('and 0')).'
                        )
                        or
                        (
                            negatif=\'NON\'
                            and casse=\'SENSIBLE\'
                            and binary \''.addslashes($chaine).'\' rlike binary expression
                            '.((sizeof($query))?('and ('.implode(' or ',$query).')'):('and 0')).'
                        )
                        or
                        (
                            negatif=\'OUI\'
                            and casse=\'SENSIBLE\'
                            and binary \''.addslashes($chaine).'\' not rlike binary expression
                            '.((sizeof($query))?('and ('.implode(' or ',$query).')'):('and 0')).'
                        )
            ';
    }
    
    public function tester(){
        return true;
    }
}
