<?php

include_once(dirname(__FILE__).'/../../core/Controller_bash.php');
class exportEmail extends Controller_bash{
    
    public $host = 'aicom.fr'; 
    public $destination = './emailing/assets/flux/'; 
    public $user = 'aicom'; 
    public $psswd = 'fiVus19--8'; 
    public $file;
    public $filename;
    
    public function __construct(){
        $this->bashname = 'Export des mails du jour';
        parent::__construct();
    }
    
    public function index(){
        $this->run();
    }
    
        
    public function execute(){
        if( $this->createCSV() ){
            $this->logger->log( 'Export du csv vers le serveur emailing' );
            $this->UploadCSV();
        }
    }
    
    public function createCSV(){
        $this->filename = date('Y-m-d').'_localerte.csv';
        $this->file = './assets/export/'.$this->filename;
        $fp = fopen( $this->file, 'a+' );
        $sql = '
                SELECT identifiant, email, passe, "" as civilite, "" as nom, "" as prenom, date_enregistrement as enregistrement
                FROM adherent 
                WHERE DATE( date_enregistrement ) = DATE( NOW() )  
            ';
        $result = $this->db->query( $sql );
        if( $result->num_rows > 0 ){
            foreach( $result->result_array() as $row ){
                $fields = array( 
                            'email' => $row['email'], 'civilite' => $row['civilite'], 'nom' => $row['nom'], 'prenom' => $row['prenom'],
                            'pays_internaute' => 'France', 'statut' => 0,  'date_enregistrement' => $row['enregistrement'], 'provenance' => 'localerte.fr'
                        );
                foreach( $fields as $key=>$field ){
                    $fields[ $key ] = '"'.$field.'"';
                }
                fwrite(  $fp, implode( ";", $fields ) );
                fwrite(  $fp, "\n" );
            }
            fclose( $fp );
            return true;
        }
        return false;
    }
    
    public function UploadCSV(){
        $ftp = ftp_connect ( $this->host );
        if( $ftp == false ){
            $this->logger->log('Erreur de connexion au ftp : '.$this->host, logger::LOG_LEVEL_CRITICAL );
            return false;
        }
        else{
            $this->logger->log('Connexion ftp reussie : '.$this->host );
        }
        
        $login = ftp_login( $ftp, $this->user, $this->psswd );
        if( $login == false ){
            $this->logger->log('Erreur de login (identifiant/mdp) au ftp : '.$this->host, logger::LOG_LEVEL_CRITICAL );
            return false;
        }
        else{
            $this->logger->log('login (identifiant/mdp) au ftp reussi: '.$this->host );
        }
        $fp = fopen($this->file, 'r');
        $ecriture = ftp_fput ( $ftp, $this->destination.$this->filename, $fp, FTP_BINARY );
        if( $ecriture == false ){
            $this->logger->log('Erreur lors du transfert du fichier '.$this->file.' vers le ftp : '.$this->host.' path : '.$this->destination, logger::LOG_LEVEL_CRITICAL );
            return false;
        }
        else{
            $this->logger->log('Transfert du fichier '.$this->file.' vers le ftp : '.$this->host.' path : '.$this->destination );
        }
        fclose( $fp );
        unlink( $this->file );        
    }
}
