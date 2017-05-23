<?php class XmlDir extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(li)+$';
    }

}

