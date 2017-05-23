<?php class XmlMenu extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(li)+$';
    }

}

