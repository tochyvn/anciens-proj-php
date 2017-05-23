<?php class XmlHtml extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(head|headbody)$';
    }

}

