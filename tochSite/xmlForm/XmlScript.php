<?php class XmlScript extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(#PCDATA)$';
    }

}

