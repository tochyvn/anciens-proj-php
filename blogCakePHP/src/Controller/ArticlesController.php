<?php

// src/Controller/ArticlesController.php

namespace App\Controller;

use Cake\ORM\TableRegistry;
//use App\Model\Entity\Article;

class ArticlesController extends AppController
{

    public function initialize() {
        parent::initialize();
        //$this->loadComponent('Flash'); // Charge le FlashComponent
    }
    
    public function index()
    {
        //echo 'tochap tu aimes trop imane'; 
        /**
         * IL EXISTE DEUX FACON DE CHARGER LES DONNEES D'UNE
         * 1- EN UTILISANT LE TableRegistry
         * 2- UTILISER LE TABLE OBJET
         */
        //$this->set('articles', $this->Articles->find('all'));
        $articles = TableRegistry::get('Articles')->find('all');
        $this->set(compact('articles'));
    }
    
    public function listeArticles() {
        $articles = $this->Articles->find('all');
        $this->set(compact('articles'));
    }
    
    public function view($id = null) {
        $article = $this->Articles->get($id);
        $this->set(compact('article'));
    }
    
    public function add() {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->data);
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Votre article a été sauvegardé.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible d\'ajouter votre article.'));
        }
        $this->set('article', $article);
    }
    
    public function edit($id = NULL) {
        //Provoque NotFoundException si cet article n'existe pas
        $article = $this->Articles->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->data);
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Votre article a été mis à jour.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible de mettre à jour votre article.'));
        }

        $this->set('article', $article);
    }
    
    public function delete($id = NULL) {
        
        //Permet la suppression uniquement en post
        $this->request->allowMethod(['post', 'delete']);

        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__("L'article avec l'id: {0} a été supprimé.", h($id)));
            return $this->redirect(['action' => 'index']);
        }
    }
    
    public function monTest() {
        $donnees = array(
            'id' => 1,
            'title' => 'tochap&imane'
        );
        /**
         * Pour creer une entité pareil on importer l'entité Article
         * $article = new Article($donnees);
         */
    
        $article1 = $this->Articles->newEntity($donnees);
        $this->set(compact('article1'));
        
    }
}

