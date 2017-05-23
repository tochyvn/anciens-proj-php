<?php class XmlButton extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(#PCDATA|p|h1|h2|h3|h4|h5|h6|div|ul|ol|dl|menu|dir|pre|hr|blockquote|address|center|noframes|table|br|span|bdo|object|applet|img|map|tt|i|b|u|s|strike|big|small|font|basefont|em|strong|dfn|code|q|samp|kbd|var|cite|abbr|acronym|sub|sup|noscript|ins|del|script)*$';
    }

}

