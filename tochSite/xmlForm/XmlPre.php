<?php class XmlPre extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^(#PCDATA|a|br|span|bdo|tt|i|b|u|s|strike|em|strong|dfn|code|q|samp|kbd|var|cite|abbr|acronym|input|select|textarea|label|button|ins|del|script)*$';
    }

}

