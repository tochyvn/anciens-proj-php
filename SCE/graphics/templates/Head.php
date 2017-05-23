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
       $host="";
       
       //-- Le bloc qui va contenir le Menu ---
       $head=new Header();
       $head->setAttribute('class', 'menu');
       echo $head->openTag(); ///--- Tag à fermer dans cette section---
       
       //--------------------
       //
       //--- Le bloc qui va contenir la bare de menu ------
       //---------------- Les rubrique UL ---
       $menu=new Ul();
       $sous_menu=new Ul();
       
       //-- Les Li du sous-menu ---
       
       $sous_menu->addLis(Array(new Li(new Text('Nouveau'), $host.'new'),
           new Li(new Text('Ouvrir'), $host.'open'),
           new Li(new Text('Enregistrer'), $host.'save'),
           new Li(new Text('Imprimer'), $host.'print')));
       
       $fichier=new Li(new Text('Fichier'),'fichier');
       $fichier->addElement($sous_menu);
       
       $edit=new Li(new Text('Edition'),'edition');
       $sous_edit=new Ul();
       $sous_edit->addLis(Array(new Li(new Text('Annuler'), $host.'cancel'),
           new Li(new Text('Supprimer'), $host.'delete'),
           new Li(new Text('Copier'), $host.'copy'),
           new Li(new Text('Coller'), $host.'past')));
       $edit->addElement($sous_edit);
       
       
       $simul = new Li(new Text('Simulation'),'simulation');
       $sous_simu = new Ul();
       $sous_simu->addLis(array (new Li(new Text('run'), $host.'run'),new Li(new Text('stop run'), $host.'stop')));
       $simul->addElement($sous_simu);
       
       //-- Menu Outils ------
       $outils = new Li(new Text('Outils'),'outils');
       $sous_outils = new Ul();
       $sous_outils->addLis(array (new Li(new Text('Deplacer'), $host.'dep'),
                                   new Li(new Text('Selectionner'), $host.'select'),
                                   new Li(new Text('Créer une relation'), $host.'link'),
                                   new Li(new Text('Roter'), $host.'rotate'),
                                   new Li(new Text('Zoom In'), $host.'zin'),
                                   new Li(new Text('Zoom Out'), $host.'zout')));
       $outils->addElement($sous_outils);
       
       $wind = new Li(new Text('Windows'),'windows');
       $sous_wind = new Ul();
       $sous_wind->addLis(array (new Li(new Text('Composants'), $host.'composants'),
           new Li(new Text('Propriétés'),$host.'proprietes'),
           new Li(new Text('Concepteur'),$host.'concepteur'),
           new Li(new Text('Wind-code'),$host.'windcode'),
           new Li(new Text('Groupe'),$host.'groupe')));
       $wind->addElement($sous_wind);
       
       $help = new Li(new Text('Help'),'help');
       $sous_help = new Ul();
       $sous_help->addLis(array(new Li(new Text('Tutoriel'), $host.'hel'),
           new Li(new Text('Document'), $host.'docs')));
       $help->addElement($sous_help);
       
       $menu->addLis(array($fichier,$edit,$simul,$outils,$wind,$help));
       echo $menu->toHTML();
       
       //--------------------------------------
       
       //----- Le bloc qui va contenir la bare d'outil ------
       
       $div_outils=new Div();
       $sp=new Span();
       $sp->setAttribute('class', 'bar_outils');
       
       //-- Image Nouveau -------
       $new=new Img();
       $new->setAttribute('src', 'graphics/upload/new.png');
       $new->setAttribute('id', 'new');
       $new->setAttribute('class', 'outils');
       $new->setAttribute('title', 'Nouveau projet');
       
       //-- Image Ouvrir --------
       $open=new Img();
       $open->setAttribute('src', 'graphics/upload/open.png');
       $open->setAttribute('id', 'open');
       $open->setAttribute('class', 'outils');
       $open->setAttribute('title', 'Ouvrir un projet');
       
       //--- Imge Sauver --------
       $save=new Img();
       $save->setAttribute('src', 'graphics/upload/save.png');
       $save->setAttribute('id', 'save');
       $save->setAttribute('class', 'outils');
       $save->setAttribute('title', 'Enregistrer');
       
       //--- Image Imprimer -----
       $print=new Img();
       $print->setAttribute('src', 'graphics/upload/print.png');
       $print->setAttribute('id', 'print');
       $print->setAttribute('class', 'outils');
       $print->setAttribute('title', 'Imprimer');
       
       //--- Image Copier -------
       $copy=new Img();
       $copy->setAttribute('src', 'graphics/upload/copy.png');
       $copy->setAttribute('id', 'copy');
       $copy->setAttribute('class', 'outils');
       $copy->setAttribute('title', 'Copier');
       
       //--- Image Coller -------
       $past=new Img();
       $past->setAttribute('src', 'graphics/upload/past.png');
       $past->setAttribute('id', 'past');
       $past->setAttribute('class', 'outils');
       $past->setAttribute('title', 'Coller');
       
       //--- Image annuler ------
       $cancel=new Img();
       $cancel->setAttribute('src', 'graphics/upload/cancel.png');
       $cancel->setAttribute('id', 'cancel');
       $cancel->setAttribute('class', 'outils');
       $cancel->setAttribute('title', 'Retour');
       
       //--- Image Supprimer -----
       $delete=new Img();
       $delete->setAttribute('src', 'graphics/upload/delete.png');
       $delete->setAttribute('id', 'delete');
       $delete->setAttribute('class', 'outils');
       $delete->setAttribute('title', 'Supprimer');
       
       //--- Image pour Run -----
       $run=new Img();
       $run->setAttribute('src', 'graphics/upload/run.png');
       $run->setAttribute('id', 'run');
       $run->setAttribute('class', 'outils');
       $run->setAttribute('title', 'Lancer la simulation');
       
       //--- Imge deplacement ---
       $dep=new Img();
       $dep->setAttribute('src', 'graphics/upload/dep.png');
       $dep->setAttribute('id', 'dep');
       $dep->setAttribute('class', 'outils');
       $dep->setAttribute('title', 'Deplacer');
       
       //--- Image Selection ----
       $select=new Img();
       $select->setAttribute('src', 'graphics/upload/select.png');
       $select->setAttribute('id', 'select');
       $select->setAttribute('class', 'outils');
       $select->setAttribute('title', 'Selection');
       
       //--- Image Lien ------
       $link=new Img();
       $link->setAttribute('src', 'graphics/upload/link.png');
       $link->setAttribute('id', 'link');
       $link->setAttribute('class', 'outils');
       $link->setAttribute('title', 'Créer des relations');
       
       //--- Image rotation -----
       $rotate=new Img();
       $rotate->setAttribute('src', 'graphics/upload/rotate.png');
       $rotate->setAttribute('id', 'rotate');
       $rotate->setAttribute('class', 'outils');
       $rotate->setAttribute('title', 'Rotation');
       
       //--- Image zoom-In ----
       $zin=new Img();
       $zin->setAttribute('src', 'graphics/upload/zin.png');
       $zin->setAttribute('id', 'zin');
       $zin->setAttribute('class', 'outils');
       $zin->setAttribute('title', 'Zoome +');
       
       //--- Image zoom-out ----
       $zout=new Img();
       $zout->setAttribute('src', 'graphics/upload/zout.png');
       $zout->setAttribute('id', 'zout');
       $zout->setAttribute('class', 'outils');
       $zout->setAttribute('title', 'Zooom -');
       
       //--- Image le tuto -----
       $hel=new Img();
       $hel->setAttribute('src', 'graphics/upload/hel.png');
       $hel->setAttribute('id', 'hel');
       $hel->setAttribute('class', 'outils');
       $hel->setAttribute('title', 'Tutoriel');
      /*
       $div_outils->addElements(array(new Li($new),new Li($open),new Li($save),new Li($print),
           new Li($copy), new Li($past), new Li($cancel), new Li($run), new Li($dep), new Li($select),
           new Li($link), new Li($rotate), new Li($zout), new Li($zin), new Li($hel)));
       */
       $sp->addElements(array($new,$open,$save,$print,$copy,$past,$cancel,$delete,$run,$dep,$select,$link,$rotate,$zout,$zin,$hel));
       $div_outils->addElement($sp);
       echo $div_outils->toHTML();
       
       //--- Fermeture de la balise div1 ---
       echo $head->closeTag();
       
    }

}

