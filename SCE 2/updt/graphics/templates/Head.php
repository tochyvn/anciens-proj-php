<?php

/* 
 * Cette classe va decrire l'entête de la page
 */
class Head {
    
    public static $div;
    
    function __construct() {
    
        
    }
    
    function getMenu() {
        
       //-- Le host -----
       $host="?cible=";
       
       //-- Le div qui va contenir le Menu ---
       $head=new Header();
       $head->setAttribute('class', 'menu');
       echo $head->openTag(); ///--- Tag à fermer dans cette section---
       
       //-- Les rubrique UL ---
       $menu=new Ul();
       $sous_menu=new Ul();
       
       //-- Les Li du sous-menu ---
       
       $sous_menu->addLis(Array(new Li(new A(new Text('Ouvrir'), $host.'open')),
           new Li(new A(new Text('Nouveau'), $host.'new')),new Li(new A(new Text('Enregistrer'), $host.'save')),
           new Li(new A(new Text('Imprimer'), $host.'print'))));
       
       $fichier=new Li(new Text('Fichier'));
       $fichier->addElement($sous_menu);
       
       $edit=new Li(new Text('Edition'));
       $sous_edit=new Ul();
       $sous_edit->addLis(Array(new Li(new A(new Text('Copier'), $host.'copy')),
           new Li(new A(new Text('Coller'), $host.'past')),
           new Li(new A(new Text('Annuler'), $host.'cancel'))));
       $edit->addElement($sous_edit);
       
       
       $simul = new Li(new Text('Simulation'));
       $sous_simu = new Ul();
       $sous_simu->addLis(array (new Li(new A(new Text('run'), $host.'run'))));
       $simul->addElement($sous_simu);
       
       $help = new Li(new Text('Help'));
       $sous_help = new Ul();
       $sous_help->addLis(array(new Li(new A(new Text('Tutoriel'), $host.'tuto')),
           new Li(new A(new Text('Document'), $host.'docs'))));
       $help->addElement($sous_help);
       
       $menu->addLis(array($fichier,$edit,$simul,$help));
       echo $menu->toHTML();
       
       //--- Fermeture de la balise div1 ---
       echo $head->closeTag();
       
    }

}

