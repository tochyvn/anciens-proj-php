<?php class XmlTbody extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(tr)+$';
    }

}

