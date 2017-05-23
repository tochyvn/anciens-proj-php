<?php

namespace App\Controller;

use App\Controller\AppController;
use \Cake\Event\Event;

class TrajetsController extends AppController {
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        //$this->Auth->allow('add');
    }
    /**
     * Listing des trajets proposés par le user connecté
     */
    public function index() {
        $trajets = $this->Trajets->find('all')
                ->where(['user_id' => $this->Auth->user('id')])
                ->contain(['Users']);
        
        $this->set('trajets', $trajets);
    }
    
    public function consulter() {
       $trajets_d = $this->Trajets->find('all')
                ->where(['user_id' => $this->Auth->user('id'), 'choix' => 'D'])
                ->contain(['Users']);
        
        $trajets_p = $this->Trajets->find('all')
                ->where(['user_id' => $this->Auth->user('id'), 'choix' => 'P'])
                ->contain(['Users']);
        
        $trajet = $this->Trajets->find('all')
                ->where(['user_id' => $this->Auth->user('id'), 'choix' => 'P'])
                ->contain(['Users'])
                ->last();
        
        //debug($trajet->destination);
        //debug($trajet->depart);
        
        if ($trajet) {
            $users = $this->Trajets->find('all')
                ->where(['depart' => $trajet->depart, 'destination' => $trajet->destination, 'choix' => 'D'])
                ->contain(['Users']); 
        }
        else {
            $users = [];
        }
        
        
        //debug($users);
                
        $this->set(['trajets_d' => $trajets_d, 
           'trajets_p' => $trajets_p, 'users' => $users, 'trajet' => $trajet ]); 
    }
    
    public function add() {
        //debug($this->Auth->user('username'));
        $trajet = $this->Trajets->newEntity();
        if ($this->request->is('post')) {
            $trajet = $this->Trajets->patchEntity($trajet, $this->request->data);
            // Ajout de cette ligne
            $trajet->user_id = $this->Auth->user('id');
            
            if ($this->Trajets->save($trajet)) {
                $this->Flash->success(__('Votre trajet a été sauvegardé.'));
                return $this->redirect(['action' => 'consulter']);
            }
        $this->Flash->error(__("Impossible d'ajouter votre trajet."));
    }
    $this->set('trajet', $trajet);
    }
    
    public function edit($id = NULL) {
        
    }
    
    public function delete($id = NULL) {
        
    }
    
    public function listeTrajets() {
        $this->set('trajets', $this->Trajets->find('all'));
    }
    
}

