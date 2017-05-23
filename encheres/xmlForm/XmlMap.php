<?php class XmlMap extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^((p|h1|h2|h3|h4|h5|h6|div|ul|ol|dl|menu|dir|pre|hr|blockquote|address|center|noframes|isindex|fieldset|table|form|noscript|ins|del|script)+|area+)$';
    }

}

