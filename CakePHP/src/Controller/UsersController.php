<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController {
    
    public function initialize() {
        parent::initialize();
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        //Ici on va permettre au utilisateur de se connecter et de s'enregistrer
        $this->Auth->allow(['add', 'login']);
        
    }
    
    public function index() {
        $this->set('users', $this->Users->find('all'));
    }
    
    public function view($id) {
        $user = $this->Users->get($id);
        $this->set(compact($user));
    }
    
    public function add() {
        //Creation d'une nouvelle entité vide dans laquelle on mettre notre objet user a insérer
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__("L'utilisateur a été sauvegardé."));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__("Impossible d'ajouter l'utilisateur."));
        }
        $this->set('user', $user);
    }
    
    public function login() {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__("Nom d'utilisateur ou mot de passe incorrect, essayez à nouveau."));
        }
    }
    
    public function logout() {
        return $this->redirect($this->Auth->logout());
        
    }
    
    public function delete($id = NULL) {
        //Permet la suppression uniquement en post
        $this->request->allowMethod(['post', 'delete']);

        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__("L'utilisateur avec l'id: {0} a été supprimé.", h($id)));
            return $this->redirect(['action' => 'listeUsers']);
        }
    }
    /*
    public function edit($id = NULL) {
        //Provoque NotFoundException si cet article n'existe pas
        $user = $this->Users->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('L\'utilisateur a été mis à jour.'));
                return $this->redirect(['action' => 'listeUsers']);
            }
            $this->Flash->error(__('Impossible de mettre à jour l\'utilisateur.'));
        }

        $this->set('user', $user);
    }
    */
    public function listeUsers() {
        $users = $this->Users->find('all');
        $this->set(compact('users'));
    }
    
}

