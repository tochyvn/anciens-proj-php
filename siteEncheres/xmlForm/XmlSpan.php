<?php class XmlSpan extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(#PCDATA|a|br|span|bdo|object|applet|img|map|iframe|tt|i|b|u|s|strike|big|small|font|basefont|em|strong|dfn|code|q|samp|kbd|var|cite|abbr|acronym|sub|sup|input|select|textarea|label|button|ins|del|script)*$';
    }

}

