<?php class XmlDl extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(dt|dd)+$';
    }

}

