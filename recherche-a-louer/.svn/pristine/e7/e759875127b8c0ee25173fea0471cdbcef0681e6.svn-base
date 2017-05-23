<?php

class Malerte extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function insererIntoLldj( $param ){
        $param['email'] = isset( $param['email'] ) ? $param['email'] : ''; 
        $param['utilisateur_id'] = isset( $param['utilisateur_id'] ) ? $param['utilisateur_id'] : ''; 
        $sql = '
                INSERT INTO inscription_lldj
                (utilisateur_id, jour, email)
                VALUES( ?, ?, ?)
            ';
        $this->db->query( $sql, array( 
                $param['utilisateur_id'],
                $param['jour'],
                $param['email']
           ) 
        );
    }
    public function insert( $param ){
        $sql = '
                INSERT INTO alerte_mail
                ( utilisateur_id, ville_id, type_id, enregistrement, statut )
                VALUES ( ?, ?, ?, ?, ? )
            ';
        $this->db->query( $sql, array( 
                $param['utilisateur_id'],
                $param['ville_id'],
                $param['type_id'],
                $param['enregistrement'],
                $param['statut']
           ) 
        );
        if( $this->db->affected_rows() > 0 ){
            return $this->db->insert_id();
        }
        return false;
    }    
    
    public function getAlerteStatut( $param ){
        $sql = '
                SELECT alerte_mail_id, am.utilisateur_id, am.ville_id, am.type_id, am.enregistrement, am.statut, v.ville_nom_reel, v.ville_slug, v.ville_code_postal, 
                tb.label_url as type_label_url
                FROM alerte_mail am
                INNER JOIN villes v ON am.ville_id = v.ville_id 
                INNER JOIN type_bien tb ON tb.type_bien_id = am.type_id 
                WHERE utilisateur_id = ? AND statut = ?
                GROUP BY utilisateur_id, ville_id, type_id
            ';
        $result = $this->db->query( $sql,
            array(
                $param['utilisateur_id'],
                $param['statut']
            )
        );
        if( $result->num_rows() > 0 ){
            foreach( $result->result_array() as $row ){
                $alertes[] = $row;
            }
            return $alertes;
        }
        return false;
    }
    
    public function delete( $param ){
        $sql = '
                DELETE FROM alerte_mail 
                WHERE alerte_mail_id = ? AND utilisateur_id = ?
            ';
        $this->db->query( $sql, array(
                $param['alerte_mail_id'],
                $param['utilisateur_id']
            ) 
        );
        if( $this->db->affected_rows() > 0 ){
            return true;
        }
        return false;
    }
    
    public function updateStatut( $param ){
        $sql = '
                UPDATE alerte_mail set 
                statut = ?  
                WHERE alerte_mail_id = ? AND utilisateur_id = ?
            ';
        $this->db->query( $sql,
            array(
                $param['statut'],
                $param['alerte_mail_id'],
                $param['utilisateur_id']
            )
        );
    }   
    
    public function getAlerteActive(){
        $sql = '
                SELECT am.alerte_mail_id, am.utilisateur_id, am.ville_id, am.type_id, am.enregistrement, am.statut, am.cp
                FROM alerte_mail am
                WHERE statut = 1
            ';
        $result = $this->db->query( $sql );
        if( $result->num_rows() > 0 ){
            foreach( $result->result_array() as $row ){
                $alertes[] = $row;
            }
            return $alertes;
        }
        return false;
    }
    
    public function getNombreAlerteActive(){
        $sql = '
                SELECT count(*) as nombre_alerte
                FROM alerte_mail am
                WHERE statut = 1
            ';
        $result = $this->db->query( $sql );
        if( $result->num_rows() > 0 ){
            return $result->row_array();
        }
        return false;
    }
    
    public function getNombreAlerteActiveDuJour(){
        $sql = '
                SELECT count(*) as nombre_alerte
                FROM alerte_mail am
                WHERE statut = 1 AND DATE(enregistrement) = DATE(NOW())
            ';
        $result = $this->db->query( $sql );
        if( $result->num_rows() > 0 ){
            return $result->row_array();
        }
        return false;
    }
    
    public function checknouveaute( $param ){
        $sql = '
                SELECT annonce_id, annonce_id_externe, reference, titre, description, contact_id, type_id, ville_id, agence_id, 
                utilisateur_id, code_postal, ville, label_type, code_insee, surface, prestige, nb_pieces, nb_chambres, cuisine, 
                grenier, terrasse, chauffage_energie, chauffage, nb_wc, nb_salles_de_bain, garage, places_garages, standing, 
                espaces_verts, jardin_privatif, nb_etages, nb_stationnements, type_stationnement, lotissement, surface_terrain, 
                nb_niveaux, cheminee, nb_chambres_rdc, piscine, vue, certificat_plomb, diagnostic_amiante, soumis_dpe, dpe_valeur_conso, 
                dpe_valeur_ges, dpe_etiquette_conso, dpe_etiquette_ges, prestation_type, mandat_type, mandat_numero, prix, date_insertion, 
                date_maj, is_payante, priorite, statut, type_payant, date_parution, statut_pro, titre_slug
                FROM annonce 
                WHERE ville_id = ? AND type_id = ? 
            ';
        $result = $this->db->query( $sql, array( $param['ville_id'], $param['type_id']) );
        if( $result->num_rows() > 0 ){
            foreach( $result->result_array() as $row ){
                $alertes[] = $row;
            }
            return $alertes;
        }
        return false;
    }
    
    public function getAlerteActiveUnique(){
        $sql = '
                SELECT am.alerte_mail_id, am.utilisateur_id, am.ville_id, am.type_id, am.enregistrement, am.statut, am.cp, v.ville_nom_reel, v.ville_slug, v.ville_code_postal, 
                tb.label_url as type_label_url, tb.label
                FROM alerte_mail am
                INNER JOIN villes v ON am.ville_id = v.ville_id 
                INNER JOIN type_bien tb ON tb.type_bien_id = am.type_id 
                WHERE statut = 1
                GROUP BY am.ville_id, am.type_id
            ';
        $result = $this->db->query( $sql );
        if( $result->num_rows() > 0 ){
            foreach( $result->result_array() as $row ){
                $alertes[] = $row;
            }
            return $alertes;
        }
        return false;
    }
    
    public function desabonner( $param ){
        $sql = '
                UPDATE alerte_mail SET statut = 2 WHERE utilisateur_id = ? 
            ';
        $this->db->query( $sql, array( $param['utilisateur_id'] ) );
        if( $this->db->affected_rows() > 0 ){
            return true;
        }
        return false;
    }
    
    public function getUtilisateurAlerteTosend(){
        $sql = '
                SELECT am.alerte_mail_id, am.utilisateur_id, am.ville_id, am.type_id, am.enregistrement, am.statut, am.cp, u.email
                FROM alerte_mail am
                INNER JOIN utilisateur u ON u.utilisateur_id = am.utilisateur_id
                WHERE am.statut = 1 
                GROUP BY u.utilisateur_id
            ';
        $result = $this->db->query( $sql );
        if( $result->num_rows() > 0 ){
            foreach( $result->result_array() as $row ){
                $alertes[] = $row;
            }
            return $alertes;
        }
        return false;
    }
    
    public function getAlerteByUser( $param ){
        $sql = '
                SELECT am.alerte_mail_id, am.utilisateur_id, am.ville_id, am.type_id, am.enregistrement, am.statut, am.cp, u.email, 
                v.ville_nom_reel, v.ville_slug, v.ville_code_postal, 
                tb.label_url as type_label_url, tb.label
                FROM alerte_mail am
                INNER JOIN utilisateur u ON u.utilisateur_id = am.utilisateur_id
                INNER JOIN villes v ON am.ville_id = v.ville_id 
                INNER JOIN type_bien tb ON tb.type_bien_id = am.type_id 
                WHERE am.statut = 1 
                AND am.utilisateur_id = ?
                GROUP BY am.ville_id, am.type_id
            ';
        $result = $this->db->query( $sql, array( $param['utilisateur_id'] ) );
        if( $result->num_rows() > 0 ){
            foreach( $result->result_array() as $row ){
                $alertes[] = $row;
            }
            return $alertes;
        }
        return false;
    }
    
    public function getAlerteById( $param ){
        $sql = '
                SELECT am.alerte_mail_id, am.utilisateur_id, am.ville_id, am.type_id, am.enregistrement, am.statut, am.cp, u.email, 
                v.ville_nom_reel, v.ville_slug, v.ville_code_postal, 
                tb.label_url as type_label_url, tb.label
                FROM alerte_mail am
                INNER JOIN utilisateur u ON u.utilisateur_id = am.utilisateur_id
                INNER JOIN villes v ON am.ville_id = v.ville_id 
                INNER JOIN type_bien tb ON tb.type_bien_id = am.type_id 
                WHERE am.statut = 1 
                AND am.alerte_mail_id = ?
            ';
        $result = $this->db->query( $sql, array( $param['alerte_mail_id'] ) );
        if( $result->num_rows() > 0 ){
            return $result->row_array();
        }
        return false;
    }
    
    public function checknouveauteMoins7Jours( $param ){
        $sql = '
                SELECT annonce_id, annonce_id_externe, reference, titre, description, contact_id, type_id, ville_id, agence_id, 
                utilisateur_id, code_postal, ville, label_type, code_insee, surface, prestige, nb_pieces, nb_chambres, cuisine, 
                grenier, terrasse, chauffage_energie, chauffage, nb_wc, nb_salles_de_bain, garage, places_garages, standing, 
                espaces_verts, jardin_privatif, nb_etages, nb_stationnements, type_stationnement, lotissement, surface_terrain, 
                nb_niveaux, cheminee, nb_chambres_rdc, piscine, vue, certificat_plomb, diagnostic_amiante, soumis_dpe, dpe_valeur_conso, 
                dpe_valeur_ges, dpe_etiquette_conso, dpe_etiquette_ges, prestation_type, mandat_type, mandat_numero, prix, date_insertion, 
                date_maj, is_payante, priorite, statut, type_payant, date_parution, statut_pro, titre_slug
                FROM annonce 
                WHERE ville_id = ? AND type_id = ? 
                AND ( DATE(date_insertion) > ? OR DATE(date_parution) > ? ) 
            ';
        $result = $this->db->query( $sql, array( $param['ville_id'], $param['type_id'], date( 'Y-m-d', time() - 86400*7 ), date( 'Y-m-d', time() - 86400*7 ) ) );
        if( $result->num_rows() > 0 ){
            foreach( $result->result_array() as $row ){
                $alertes[] = $row;
            }
            return $alertes;
        }
        return false;
    }
    
    public function insertAlerteEnvoi( $param ){
        $sql = '
                INSERT INTO alerte_envoi
                    (heure_debut, nombre_envoi, nombre_alerte, nombre_ouverture, nombre_click, nombre_mer, nombre_rejet, 
                    nombre_alerte_sans_nouveaute, nombre_alerte_avec_nouveaute, desabonnement)
                VALUES (?,?,?,?,?,?,?,?,?,?)
            ';
        $this->db->query( $sql, 
            array(
                $param['heure_debut'],
                $param['nombre_envoi'],
                $param['nombre_alerte'],
                $param['nombre_ouverture'],
                $param['nombre_click'],
                $param['nombre_mer'],
                $param['nombre_rejet'],
                $param['nombre_alerte_sans_nouveaute'],
                $param['nombre_alerte_avec_nouveaute'],
                $param['desabonnement'],
            )
        );
        if( $this->db->affected_rows() > 0 ){
            return $this->db->insert_id();
        }
        return false;
    }
    
    public function insertAlerteEnvoiMail( $param ){
        $sql = '
                INSERT INTO alerte_envoi_email
                (utilisateur_id, heure, alerte_envoi_id, nombre_alerte, ouverture, click, lead)
                VALUES ( ?, ?, ?, ?, ?, ?, ? )
             ';
        $this->db->query( $sql, 
            array(
                $param['utilisateur_id'],
                $param['heure'],
                $param['alerte_envoi_id'],
                $param['nombre_alerte'],
                $param['ouverture'],
                $param['click'],
                $param['lead']
            )
        ); 
        if( $this->db->affected_rows() > 0 ){
            return $this->db->insert_id();
        }
        return false;
    }
    
    public function updateouverture( $param ){
        $sql = '
                UPDATE alerte_envoi_email
                SET ouverture = ?, 
                heure_ouverture = ? 
                WHERE utilisateur_id = ? AND alerte_envoi_id = ? 
            ';
        $this->db->query( $sql, 
            array(
                1,
                $param['heure_ouverture'],
                $param['utilisateur_id'],
                $param['alerte_envoi_id']
            )
        ); 
        if( $this->db->affected_rows() > 0 ){
            return $this->db->insert_id();
        }
        return false;
    }
    
    public function updateClick( $param ){
        $sql = '
                UPDATE alerte_envoi_email
                SET click = click + 1, 
                heure_click = ? 
                WHERE utilisateur_id = ? AND alerte_envoi_id = ? 
            ';
        $this->db->query( $sql, 
            array(
                $param['heure_click'],
                $param['utilisateur_id'],
                $param['alerte_envoi_id']
            )
        ); 
        if( $this->db->affected_rows() > 0 ){
            return $this->db->insert_id();
        }
        return false;
    }
    
    public function updateDesabonnement( $param ){
        $sql = '
                UPDATE alerte_envoi_email
                SET desabonnement = 1 
                WHERE utilisateur_id = ? AND alerte_envoi_id = ? 
            ';
        $this->db->query( $sql, 
            array(
                $param['utilisateur_id'],
                $param['alerte_envoi_id']
            )
        ); 
        if( $this->db->affected_rows() > 0 ){
            return $this->db->insert_id();
        }
        return false;
    }
}
