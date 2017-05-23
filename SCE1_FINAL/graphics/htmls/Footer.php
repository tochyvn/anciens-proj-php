<?php

class Footer extends ElementNonVide{

    function __construct() {
        parent::__construct();
        
        //--- Section pied de page --
        $hg=new Hgroup();
        
        $this->setAttribute('class', 'footer');
        $sitmap=new Div();
        $sitmap->setAttribute('class', 'sitmap');
        $sitmap->addElement(new Text('Ce site est développé par un groupe d\'étudiants lors d\'un projet '
                . 'tutoré marquant la fin de leur formation en niveau Licence Pro.'
                . '<br>Ce groupe est constitué d\'un analyste (Yvanov Tochap), d\'un web-desiner(Ben boina kader),'
                . 'd\'un Reporter<br>(Faxi Chafik),d\'un gestionnaire de projet(Hassen Chater),'
                . 'et du chef du projet(Mohamed Ali Idjabou)'));
        $hg->addElement($sitmap);
        $copyright=new Div();
        $copyright->setAttribute('class', 'copyright');
        $copyright->addElement(new Text('<a href="http://richard-ostrowski.eu/SILNTI/">SIL-NTI</a> CopyRight@2015 Mc.'));
        $copyright->setAttribute('class', 'copyright');
        $hg->addElement($copyright);
        
        $this->addElement($hg);
    }
    

}
