<?php class XmlStyle extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(#PCDATA)$';
    }

}

