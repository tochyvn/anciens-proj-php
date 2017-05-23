<?php

class XmlZoneCheckbox extends XmlDiv {

    public static $count = 0;

    public function __construct(array $t) {
        if (!isset($t['name']) or !isset($t['label']) or !isset($t['checkbox']) or !isset($t['min']) or !isset($t['max']))
            throw(new Exception("label, name, checkbox, min or max missing in XmlZoneCheckbox "));
        $this->params = $t;
        $text = new XmlText($t['label']);
        $label = new XmlLabel();
        $label->addElement($text);
        $this->addElement($label);
        $this->addAttribute("class", "zone_checkbox zone_form");
        $div = new XmlDiv();

        foreach ($t['checkbox'] as $key => $value) {
            $l = new XmlLabel(array("for" => "zone_checkbox" . self::$count));
            $text = new XmlText($key);
            $l->addElement($text);
            $div->addElement($l);
            $input = new XmlInput(array("type" => "checkbox", "value" => $value, "id" => "zone_checkbox" . self::$count, "name" => $t['name'] . "[]"));
            if ((isset($_REQUEST[$this->params['name']])) and (in_array($value, $_REQUEST[$this->params['name']])))
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
        if ((!$value and $this->params['min'] > 0) or ($value and (count($value) > $this->params['max'] or count($value) < $this->params['min'] ))) {
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

