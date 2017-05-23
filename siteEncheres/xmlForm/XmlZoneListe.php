<?php

class XmlZoneListe extends XmlDiv {

    public function getTagName() {
        return 'div';
    }

    public function __construct(array $t) {
      
        if (!isset($t['name']) or !isset($t['label']) or !isset($t['options']) or !isset($t['min']) or !isset($t['max']))
            throw(new Exception("label, name, options, min or max missing in XmlZoneListe "));

        $this->params = $t;
        $text = new XmlText($t['label']);
        $label = new XmlLabel();
        $label->addElement($text);
        $this->addElement($label);
        $this->addAttribute("class", "zone_liste zone_form");

        $sel = new XmlSelect(array("name" => $this->params['name'] . "[]"));

        if (isset($this->params['multiple']))
            $sel->addAttribute("multiple", "multiple");

        $opt = new XmlOption(array("value" => "@@@@@@@@"));
        $text = new XmlText("-----Select-----");
        $opt->addElement($text);
        $sel->addElement($opt);

        foreach ($t['options'] as $key => $value) {
            $opt = new XmlOption(array("value" => $key));
            $text = new XmlText($value);
            $opt->addElement($text);
            if ((isset($_REQUEST[$this->params['name']])) and (in_array($key, $_REQUEST[$this->params['name']])))
                $opt->addAttribute("selected", "selected");
            $sel->addElement($opt);
        }
        $this->addElement($sel);
    }

    public function valider() {

        if (isset($_REQUEST[$this->params['name']]))
            $value = $_REQUEST[$this->params['name']]; //on est sûr de toujours l'avoir
        else
            $value = array();
        if (in_array("@@@@@@@@", $value) or
                count($value) > $this->params['max'] or
                count($value) < $this->params['min']) {
            // on rajoute un \351l\351ment span contenant le message d'erreur avec une classe CSS msgError
            // on rajoute un élément span contenant le message d'erreur avec une classe CSS msgError
            $span = new XmlSpan();

            if (isset($this->params['msgErr']))
                $span->addElement(new XmlText($this->params['msgErr']));
            else
                $span->addElement(new XmlText('* required'));

            $this->addElement($span);
            return 1;
        }
        return 0;
    }

}

?>