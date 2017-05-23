<?php class XmlTextarea extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(#PCDATA)$';
    }

}

