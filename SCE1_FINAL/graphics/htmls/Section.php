<?php

class Section extends ElementNonVide{

    function __construct() {
        parent::__construct();
        
        //--- Bloc Conception ---
        $bloc_concept=new Hgroup();
        $px=new H3();
        $px->addElement(new Text('X'));
        $bloc_concept->addElement($px);
        
        $canv=new Div();
        $canv->setAttribute('class', 'drop');
        
        $canv->setAttribute('id', 'drop');
        //$canv->setAttribute('style', 'width:750px; height:633px');
        $bloc_concept->addElement($canv);
        $this->addElement($bloc_concept);
        
        
        //--- Bloc Code ---------
        $bloc_code=new Span();
        $bloc_code->setAttribute('class', 'code');
        $p=new P();
        
        $code_label=new Label('graphic');
        $code_label->addElement(new Text('Graphics'));
        $p->addElement($code_label);
        
        $code_php=new Label('php');
        $code_php->addElement(new Text('Php'));
        $p->addElement($code_php);
        
        $h=new H3();
        $h->addElement(new Text('X'));
        //$p->addElement($h);
        $bloc_code->addElement($p);
        $bloc_code->addElement($h);
        
        //--- Zonte TextArea pour affichage du code --
        $code=new Textarea();
        $bloc_code->addElement($code);
        
        $this->addElement($bloc_code);
        
    }

}
