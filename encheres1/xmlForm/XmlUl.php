<?php class XmlUl extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(li)+$';
    }

}

