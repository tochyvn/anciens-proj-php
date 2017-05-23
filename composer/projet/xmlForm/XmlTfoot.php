<?php class XmlTfoot extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(tr)+$';
    }

}

