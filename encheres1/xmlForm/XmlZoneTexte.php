<?php

class XmlZoneTexte extends XmlDiv {

    public static $count = 0;

    public function __construct(array $t) {
        if (!isset($t['name']) or (!isset($t['label'])))
            throw(new Exception("label or name missing in XmlZoneTexte "));
        $this->params = $t;
        $this->addAttribute("class", "zone_texte zone_form"); //identifiant commun de chaque zone de texte
        $text = new XmlText($t['label']);
        $label = new XmlLabel();
        $label->addAttribute("for", "zone_texte" . self::$count); //gestion interne des identifiants
        $label->addElement($text);
        $input = new XmlInput(array("type" => "text", "id" => "zone_texte" . self::$count, "name" => $t['name'], "value" => isset($t['value']) ? $t['value'] : ''));
        $value = (isset($_REQUEST[$this->params['name']])) ? $_REQUEST[$this->params['name']] : "";
        $input->addAttribute("value", $value); //elements[1] repr\351sente bien l'\351l\351ment input

        $this->addElement($label);
        $this->addElement($input);
        self::$count++; // incrémentation du compteur pour le prochain objet de type zone_texte
    }

    public function getTagName() {
        return 'div';
    }

    public function valider() {
        $value = (isset($_REQUEST[$this->params['name']])) ? $_REQUEST[$this->params['name']] : "";

        if (isset($this->params['regex']) && !preg_match('/' . $this->params['regex'] . '/', $value)) {
            // on rajoute un élément span contenant le message d'erreur avec une classe CSS msgError
            $span = new XmlSpan();

            if (isset($this->params['msgErr']))
                $span->addElement(new XmlText($this->params['msgErr']));
            else
                $span->addElement(new XmlText('* required'));

            $this->addElement($span);

            //on ajoute aussi une classe CSS inputZoneTexte \340 la balise input 
            $this->elements[1]->addAttribute("class", "inputError");
            return 1;
        }
        return 0;
    }

}

