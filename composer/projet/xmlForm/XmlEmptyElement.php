<?php abstract  class XmlEmptyElement extends XmlElement {

    final public function getAllowedElements() {
        return null;
    }

    public function toHTML() {
        $str = "<" . $this->getTagName();
        foreach ($this->attributes as $key => $value)
            $str.=' ' . $key . '="' . $value . '"';
        $str.="/>";
        return $str;
    }

}

