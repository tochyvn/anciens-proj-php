<?php class XmlColgroup extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(col)*$';
    }

}

