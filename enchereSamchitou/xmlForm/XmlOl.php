<?php class XmlOl extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(li)+$';
    }

}

