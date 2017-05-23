<?php class XmlTr extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(th|td)+$';
    }

}

