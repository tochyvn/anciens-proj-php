<?php class XmlTitle extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(#PCDATA)$';
    }

}

