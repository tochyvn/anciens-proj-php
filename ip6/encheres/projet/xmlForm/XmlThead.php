<?php class XmlThead extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(tr)+$';
    }

}

