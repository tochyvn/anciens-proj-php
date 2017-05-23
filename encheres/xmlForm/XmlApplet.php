<?php class XmlApplet extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(#PCDATA|param|p|h1|h2|h3|h4|h5|h6|div|ul|ol|dl|menu|dir|pre|hr|blockquote|address|center|noframes|isindex|fieldset|table|form|a|br|span|bdo|object|applet|img|map|iframe|tt|i|b|u|s|strike|big|small|font|basefont|em|strong|dfn|code|q|samp|kbd|var|cite|abbr|acronym|sub|sup|input|select|textarea|label|button|noscript|ins|del|script)*$';
    }

}

