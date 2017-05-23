<?php

/**
 * Description of annonce
 *
 * @author aicom
 */
class annonce extends CI_Model{
    
    const ACTION_AJOUT = 'ajoute';
    const ACTION_MODIFIE = 'modifie';
    const SEUIL_ANNONCE_PREMIUM_JOUR = 3;
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('string');
    }
    
    
    public function getAnnonceById($annonce_id){
        $sql = '
                SELECT url 
                FROM location_annee_liste 
                where identifiant = '.(int)$annonce_id.'
                LIMIT 1
            ';
        $result = $this->db->query($sql);
        if( $result->num_rows() > 0 ){
            $annonce = $result->row_array();
            return $annonce;
        }
        return array('error' => true, 'msg' => 'Pas d\'annonce pour l\'id'.$annonce_id);
    }
    /**
     * Methode qui recupere le nombre d'annonce de moins de 3 jours 
     * (chiffre affiche sur la page d'accueil du site)
     * @return int|array(error|msg) 
     */
    public function getNombreAnnonceMoins3Jour(){
        $sql = '
                SELECT 
                    count(*) as nombre_annonce 
                FROM location_annee_liste 
                WHERE statut_affichage = 1
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            $nombre_annonce = $result->row_array();
            return $nombre_annonce['nombre_annonce'];
        }
        return array('error' => true, 'msg' => "No records");
    }
    
    /**
     * Methode de recherche permettant de lister les annonces en fonction des parametres 
     * envoyes par l'utilisateur
     * @param array $immobiliers
     * @param array $villes
     */

    public function recherche($immobiliers, $recherche_lieu, $premium = false, $filtres = array(), $tris = array()){
        // 3 cas possibles 
        // regions, dept ou ville
        switch ($recherche_lieu['type']){
            case 'ville':
                $ville = $recherche_lieu['valeur'];
            break;
            case 'departement':
                $departement = $recherche_lieu['valeur'];
            break;
            case 'region':
                $region = $recherche_lieu['valeur'];
            break;
            default :
            return array('error' => true, 'msg' => 'pas de type de recherche sur le lieu');
        }
        
        // filtre commun a toutes les recherches (que ce soit sur la ville le dept ou la region
        $filtre_statut = '';
        if(isset($filtres['statut']) && $filtres['statut'] != null){
            $filtre_statut = ' AND lal.statut = "'.$this->db->escape_like_str($filtres['statut']).'" ';
        }
        
        
        if(is_array($immobiliers)){
            // on concatene les differents type d'immobilier dans une chaine
            $immo_string = arrayTostring($immobiliers, ',');
            $condition_immo = ' AND lal.type_identifiant IN ('.$immo_string.') ';
        }
        else{
            // on recherche tous les types d'immobiliers
            $condition_immo = '';
        }
        // le tableau d'annonce a renvoyer
        $annonces = array();
        
        // mise en place des filtres et des tris pour la recherche des annonces
        if($premium == false){
            // on recupere les annonces de plus de 3 jours
            $condition_parution = ' DATEDIFF(DATE(NOW()),  FROM_UNIXTIME(lal.parution)) > '.self::SEUIL_ANNONCE_PREMIUM_JOUR.' ';
        }
        else{
            $condition_parution = ' DATEDIFF(DATE(NOW()),  FROM_UNIXTIME(lal.parution)) < '.self::SEUIL_ANNONCE_PREMIUM_JOUR.' ';
        }
        
        // par defaut on tris par distance, type de bien immobilier, et date de parution
        if(empty($tris)){
            $order_by = '';
            if($recherche_lieu['type'] == 'ville' ){
                $order_by = ' ORDER BY distance, lal.type_identifiant, lal.parution ';
            }
            else{
                $order_by = ' ORDER BY lal.type_identifiant, lal.parution ';
            }
        }
        else{
            if(isset($tris['parution']) && $tris['parution'] != null){
                $order_by = ' ORDER BY lal.parution '.$tris['parution'].' ' ;
            }
            
            if(isset($tris['loyer']) && $tris['loyer'] != null){
                $order_by = ' ORDER BY lal.prix '.$tris['loyer'].' ' ;
            }
            
            if(isset($tris['ville']) && $tris['ville'] != null){
                $order_by = ' ORDER BY lal.ville_nom '.$tris['ville'].' ' ;
            }
        }
        
        // corps de la requete sql commun aux 3 recherches
        $select = '
                SELECT 
                    lal.identifiant, 
                    lal.ville_nom,
                    lal.provenance_classification,
                    lal.ville_identifiant,        
                    lal.parution,
                    lal.prix,
                    lal.statut,
                    lal.type_designation,
                    lal.photo,
                    lal.url,
                    lal.description
            ';
        
        $from = ' FROM location_annee_liste lal ';
        $where = ' WHERE ';
        
        
        // filtre de distance specifique a la recherche a partir d'une ville
        if($recherche_lieu['type'] == 'ville' ){
            $having = '';
            $distance = '';
            if(isset($filtres['distance']) && $filtres['distance'] != null){
                $having = ' HAVING distance < '.(int)$filtres['distance'].' ';
                // cette varible est recupere dans le select quand on recherche par rapport a une ville
                $distance = '
                    ,
                    ifnull(round((6366*acos(cos(radians('.(float)$ville['latitude'].'))*cos(radians(ville_latitude))*cos(radians(ville_longitude) 
                        -
                    radians('.(float)$ville['longitude'].'))+sin(radians('.(float)$ville['latitude'].'))*sin(radians(ville_latitude)))),0),0) 
                    as distance 
                ';
            }
            $sql = $select.$distance.$from.$where.$condition_parution.$condition_immo.$filtre_statut.$having.$order_by;
        }
        
        if( $recherche_lieu['type'] == 'departement' ){
            $jointure = '
                    INNER JOIN ville v ON v.identifiant = lal.ville_identifiant
                    INNER JOIN departement d ON d.identifiant = v.departement
                ';
            $condition_departement = 'AND d.identifiant = '.$departement['identifiant'].'';
            
            $sql = $select.$from.$jointure.$where.$condition_parution.$condition_immo.$filtre_statut.$condition_departement.$order_by;
        }
        
        if( $recherche_lieu['type'] == 'region' ){
            $jointure = '
                    INNER JOIN ville v ON v.identifiant = lal.ville_identifiant
                    INNER JOIN departement d ON d.identifiant = v.departement
                    INNER JOIN region r ON r.identifiant = d.region
                ';
            $condition_region = 'AND r.identifiant = '.$region['identifiant'].'';
            
            $sql = $select.$from.$jointure.$where.$condition_parution.$condition_immo.$filtre_statut.$condition_region.$order_by;
        }
        $result = $this->db->query($sql);
        if( $result->num_rows() > 0 ){
            foreach($result->result_array() as $row){
                $annonces[] = $row;
            }
            return $annonces;
        }
    }
    
    /**
     * 
     * @param sting $provenance
     * @param sting $reference
     * @return array (error|msg|identifiant)
     */
    public function ifAnnonceExists($provenance, $reference){
        $sql = '
                select identifiant, brule
                from annonce
                where provenance = "'.$this->db->escape_like_str($provenance).'"
                and reference = "'.$this->db->escape_like_str($reference).'"
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            $result = $result->row_array();
            $identifiant = $result['identifiant'];
            return array('statut' => '0', 'msg' => 'annonce déjà présente', 'identifiant' => $identifiant, 'annonce' => $result );
        }
        return array('statut' => 1, 'msg' => 'nouvelle annonce', 'identifiant' => null );
    }
    
    /**
     * modifie l'affichage des annonces de locamax 
     * execute pendant le cron d'import des annonces
     * si le statut affichage est à 0 l'annonce n'est plus affiche sur le site 
     * et elle est ensuite supprimé par le cron
     * @param int $provenance clef primaire de la table provenance
     * @param int $statut 0 ou 1
     * @return boolean
     */
    public function setAffichage($provenance, $statut, $annonce_id = false){
        $condition = '';
        if($annonce_id != false){
            $condition = 'AND annonce_id = '.(int)$annonce_id.' ' ;
        }
        $sql = '
                UPDATE location_annee_liste
                SET statut_affichage = '.(int)$statut.'
                WHERE provenance_identifiant = '.(int)$provenance.'
                '.$condition.'    
                
            ';
        $this->db->query($sql);
        if($this->db->affected_rows() > 0){
            return true;
        }
        return array('error' => true, 'msg' => 'Echec de la modification de l\'affichage des annonces');
    }
    
    /**
     * Supprime les annonces dont le parametre statut_affichage est a 0
     * (les annonces perimes qui ne sont plus recuperes par la pige)
     */
    public function deleteOldAnnonce(){
        $sql = '
                SELECT annonce_id 
                FROM location_annee_liste
                WHERE statut_affichage = 0
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            foreach($result->result_array() as $row){
                $sql = '
                        UPDATE annonce
                        SET brule = "OUI"
                        WHERE identifiant = "'.$row['annonce_id'].'"
                    ';
                $this->db->query($sql);
            }
        }
        $sql = '
                DELETE FROM location_annee_liste
                WHERE statut_affichage = 0
            ';
        $this->db->query($sql);
    }
    
    /**
     * Lance le traitement d'une annonce lors de l'import
     * 2 cas : ajout d'une nouvelle annonce
     *         mise a jour d'une ancienne annonce 
     * @param array $annonce
     * @param string $mode
     */
    public function traitement($annonce, $mode){
        switch($mode){
            case self::ACTION_AJOUT:
                $this->ajouterAnnonce($annonce);
            break;
            case self::ACTION_MODIFIER:
                $this->modifierAnnonce($annonce);
            break;
        }
    }
    
    public function modifierAnnonce($annonce){
        $this->setAffichage($annonce['provenance_identifiant'], 1, $annonce['identifiant']);
    }
    
    /**
     * ajoute une annonce en BDD (dans les tables location_annee_liste et annonce)
     * @param array $annonce
     * @return boolean
     */
    public function ajouterAnnonce($annonce){
        $annonce_id = '';
        $sql = '
                INSERT INTO annonce
                (
                    reference, 
                    provenance, 
                    titre, 
                    description, 
                    ville, 
                    prix, 
                    enregistrement, 
                    modification, 
                    parution, 
                    statut, 
                    telephone1, 
                    telephone2, 
                    email, 
                    url, 
                    photo
                )
                VALUES 
                (
                    "'.$this->db->escape_like_str($annonce['reference']).'",
                    "'.(int)$annonce['provenance_identifiant'].'",
                    "'.$this->db->escape_like_str($annonce['titre']).'",
                    "'.$this->db->escape_like_str($annonce['description']).'",
                    "'.(int)$annonce['ville'].'",
                    "'.(float)$annonce['prix'].'",
                    NOW(),     
                    NOW(),
                    "'.$this->db->escape_like_str($annonce['parution']).'",
                    "'.$this->db->escape_like_str($annonce['statut']).'",
                    "'.$this->db->escape_like_str($annonce['telephone1']).'",
                    "'.$this->db->escape_like_str($annonce['telephone2']).'",
                    "'.$this->db->escape_like_str($annonce['email']).'",
                    "'.$this->db->escape_like_str($annonce['url']).'",
                    "'.$this->db->escape_like_str($annonce['photo']).'"
                )
            ';
        $this->db->query($sql);
        if($this->db->affected_rows() > 0){
            // on recupere l'id de l'annonce inseree
            $annonce_id = $this->db->insert_id();
        }
        else{
            return array('error' => true, 'Insertion dans la table annonce');
        }
        
        $sql = '
                INSERT INTO location_annee_liste
                (
                    titre, description, parution, enregistrement, modification, prix, statut, meuble, prix_not_null, ville_identifiant, 
                    ville_code_postal, ville_nom, ville_nom_accent, ville_longitude, ville_latitude, photo, url, type_identifiant, type_designation, 
                    type_parent, provenance_identifiant, provenance_designation, provenance_classification, doublon, statut_affichage, annonce_id
                )
                VALUES 
                (
                    "'.$this->db->escape_like_str($annonce['titre']).'",
                    "'.$this->db->escape_like_str($annonce['description']).'", 
                    "'.$this->db->escape_like_str($annonce['parution']).'",
                    "'.time().'",
                    "'.time().'",
                    '.(float)$annonce['prix'].', 
                    "'.$this->db->escape_like_str($annonce['statut']).'",
                    "'.$this->db->escape_like_str($annonce['meuble']).'",
                    '.(int)$annonce['presence_prix'].', 
                    '.(int)$annonce['ville_id'].', 
                    "'.$this->db->escape_like_str($annonce['cp']).'",
                    "'.$this->db->escape_like_str($annonce['ville_nom']).'", 
                    "'.$this->db->escape_like_str($annonce['ville_nom_accent']).'", 
                    "'.$this->db->escape_like_str($annonce['ville_longitude']).'", 
                    "'.$this->db->escape_like_str($annonce['ville_latitude']).'", 
                    "'.$this->db->escape_like_str($annonce['photo']).'", 
                    "'.$this->db->escape_like_str($annonce['url']).'", 
                    "'.(int)($annonce['type_identifiant']).'", 
                    "'.(int)($annonce['type_designation']).'", 
                    "'.(int)($annonce['type_parent']).'", 
                    "'.(int)($annonce['provenance_identifiant']).'", 
                    "'.$this->db->escape_like_str($annonce['provenance_designation']).'", 
                    "'.$this->db->escape_like_str($annonce['provenance_classification']).'", 
                    "'.$this->db->escape_like_str($annonce['doublon']).'", 
                    1,
                    '.(int)$annonce_id.'
                )
            ';
        $this->db->query($sql);
        if($this->db->affected_rows() > 0){
            return true;
        }
        return array('error' => true, 'Insertion dans la table location_annee_liste');
    }
    
}
