<?php

class XmlForm extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(#PCDATA|p|h1|h2|h3|h4|h5|h6|div|ul|ol|dl|menu|dir|pre|hr|blockquote|address|center|noframes|isindex|fieldset|table|a|br|span|bdo|object|applet|img|map|iframe|tt|i|b|u|s|strike|big|small|font|basefont|em|strong|dfn|code|q|samp|kbd|var|cite|abbr|acronym|sub|sup|input|select|textarea|label|button|noscript|ins|del|script)*$';
    }

    public function __construct(array $t) {
        parent::__construct($t);
        
        //ajout d'un token pour éviter la faille CRSF
        if (!isset($_SESSION['XmlFormToken'])) $_SESSION['XmlFormToken'] = sha1(uniqid(rand(), true));
        $this->addElement(new XmlInput(array("type" => "hidden", "name" => "XmlFormToken", "value" => $_SESSION['XmlFormToken'])));
    }

    public function formulaireValide() {
        $erreur = 0;
        if ((isset($_SESSION['XmlFormToken']) && ($_SESSION['XmlFormToken'] != $_REQUEST['XmlFormToken']))) {
            echo "Erreur token";
            $erreur = 1;
        }
        else
            foreach ($this->elements as $element)
                $erreur+=$element->valider();
        
        //création du nouveau token
        $_SESSION['XmlFormToken'] = sha1(uniqid(rand(), true));
        $this->elements[0]->setAttribute("value",$_SESSION['XmlFormToken']);
        
        return !$erreur;
    }

    public function donneesEnvoyees() {
        return (isset($_REQUEST['XmlFormToken']));
    }

}

