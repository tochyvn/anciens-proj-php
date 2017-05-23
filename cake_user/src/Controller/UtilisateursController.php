<?php

namespace App\Controller;

use App\Controller\AppController;

class UtilisateursController extends AppController {
    
    public function liste1() {
        $utilisateurs = $this->Utilisateurs->find('all')
             ->where(['id >' => 1]);
        
        $this->set('utilisateurs', $utilisateurs);
    }
    
    public function index() {
        $this->set('utilisateurs', $this->Utilisateurs->find('all'));
    }
    /**
     * Controleur permettant d'ajouter un utilisateur
     */
    public function add() {
        //On crée une entité de la table utilisateur correspondant à un enregistrement de la table
        $utilisateur = $this->Utilisateurs->newEntity();
        //Si des données ont été envoyé dans le formulaire en post
        if ($this->request->is('post')) {
            //On met les donneés envoyées dans l'enntité crée plus haut
            $utilisateur = $this->Utilisateurs->patchEntity($utilisateur, $this->request->data);
            //On teste si l'insertion s'est bien passée de l'entité dans la table Utilisateur 
            if ($this->Utilisateurs->save($utilisateur)) {
                //Envoie en session du message à afficher dans la vue qui sera charger
                $this->Flash->success(__('Votre utilisateur a été inséré avec succès'));
                //Rediretion vers la vue index
                $this->redirect(['action'=>'index']);
            }
            $this->Flash->error(__('Impossible d\'insérer l\'utilisateur'));
        }
        //Envoie à la vue add.ctp de l'entité 
        $this->set('utilisateur', $utilisateur);
    }
    
}

