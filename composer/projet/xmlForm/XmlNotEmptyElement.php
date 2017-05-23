<?php

abstract class XmlNotEmptyElement extends XmlElement {

    protected $elements = array();

    final public function getElements() {
        return $this->elements;
    }

    /*
      permet d'ajouter un \351l\351ment en tant que dernier fils.
      Cette fonction v\351rifie que l'on est autoris\351 \340 ins\351rer l'\351lement.
      Une v\351rification est faite par rapport \340 la DTD xhtml strict.
      Dans la prochaine version, il y aura aussi un contr\364le des attributs (ainsi que les valeurs autoris\351es)
     */

    public function addElement($e) {
        $str = "";
        foreach ($this->elements as $element)
            if ($element->getTagName() != '#PCDATA')
                $str.=strtolower($element->getTagName());
            else
                $str.=$element->getTagName();

        if ($e->getTagName() != '#PCDATA')
            $str.=strtolower($e->getTagName());
        else
            $str.=$e->getTagName();
        
        if (preg_match('/' . $this->getAllowedElements() . '/', $str))
            $this->elements[] = $e;
        else {
            $msg = "balise " . $e->getTagName() . " non autoris\351e dans la balise " . $this->getTagName() . " ou ins\351r\351e au mauvais endroit";
            throw(new Exception($msg));
        }
    }

    public function toHTML() {
        $str = "<" . $this->getTagName();
        foreach ($this->attributes as $key => $value)
            $str.=' ' . $key . '="' . $value . '"';
        $str.=">";
        foreach ($this->getElements() as $element)
            $str.=$element->toHTML();
        $str.="</" . $this->getTagName() . ">";
        return $str;
    }

}

