<?php class XmlSelect extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(optgroup|option)+$';
    }

}

