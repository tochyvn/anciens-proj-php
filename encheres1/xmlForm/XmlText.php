<?php class XmlText {

    private $str;

    public function __construct($str) {
        $this->str = $str;
    }

    public function toHTML() {
        return $this->str;
    }

    public function getTagName() {
        return '#PCDATA';
    }

}

/* Les classes qui suivent sont de nouveaux composants sp\351cialement pour les formulaires.
  Sont d\351finies : les zones de texte, les zones radios, les zones checkboxes et les listes
  (s\351lection simple ou multiple). Pour d\351finir ses propres composants, il se d\351finir l'\351l\351ment racine
  (un \351l\351ment de type block par exemple). Ensuite libre \340 vous de d\351finir la structure interne de votre composant.

 */



/*
  Le composant zone de texte permet d'afficher une zone de texte muni d'un label. L'\351l\351ment racine sera un div.
  Dans le cas o\371 l'on d\351finit un message d'erreur, il sera ajout\351 comme dernier fils dans une balise span

  A la cr\351ation de l'objet il faut lui passer en param\352tre un tableau associatif comportant obligatoirement :
  "label"=>"Entrez votre nom :" -> peut \352tre facultatif
  "msgErr"=>"ne peut contenir que des minuscules" -> facultatif un message standart s'affichera
  "regex"=>"^[a-z]+$" -> facultatif mais vivement conseill\351 pour valider le formulaire
  "name"=>"nom" -> obligatoire pour la r\351cup\351ration et validation du texte

  Il est possible de personaliser l'affichage des \351l\351ments en CSS:
  - le bloc poss\350de la classe .zone_texte
  - le label est accessible via .zone_texte > label
  - l'input est accessible via .zone_texte > input
  - le message d'erreur via .zone_texte > span
  - .inputError pour colorer la zone de texte
 */

