<?php class XmlOption extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(#PCDATA)$';
    }

}

