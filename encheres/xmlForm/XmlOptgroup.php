<?php class XmlOptgroup extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(option)+$';
    }

}

