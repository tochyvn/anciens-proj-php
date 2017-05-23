<?php

class XmlZoneRadio extends XmlDiv {

    public static $count = 0;

    public function __construct(array $t) {
        if (!isset($t['name']) or !isset($t['label']) or !isset($t['radio']))
            throw(new Exception("label, name, radio, min or max missing in XmlZoneRadio "));
        $this->params = $t;
        $text = new XmlText($t['label']);
        $label = new XmlLabel();
        $label->addElement($text);
        $this->addElement($label);
        $this->addAttribute("class", "zone_radio zone_form");
        $div = new XmlDiv();
        foreach ($t['radio'] as $key => $value) {
            $l = new XmlLabel(array("for" => "zone_radio" . self::$count));
            $text = new XmlText($key);
            $l->addElement($text);
            $div->addElement($l);
            $input = new XmlInput(array("type" => "radio", "value" => $value, "id" => "zone_radio" . self::$count, "name" => $t['name']));
            // if (in_array("checked", $value))
            //     $input->addAttribute("checked", "checked");
            if ((isset($_REQUEST[$this->params['name']])) and ($value == $_REQUEST[$this->params['name']]))
                $input->addAttribute("checked", "checked");
            $br = new XmlBr();
            $div->addElement($input);
            $div->addElement($br);
            self::$count++;
        }
        $this->addElement($div);
    }

    public function getTagName() {
        return 'div';
    }

    public function valider() {
        $value = (isset($_REQUEST[$this->params['name']])) ? $_REQUEST[$this->params['name']] : 0;
        if (isset($this->params['obligatoire']) and !isset($_REQUEST[$this->params['name']])) {
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

