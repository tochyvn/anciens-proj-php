<?php class XmlHead extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^((script|style|meta|link|object|isindex)*,((title,(script|style|meta|link|object|isindex)*,(base,(script|style|meta|link|object|isindex)*)?)|(base,(script|style|meta|link|object|isindex)*,(title,(script|style|meta|link|object|isindex)*))))$';
    }

}

