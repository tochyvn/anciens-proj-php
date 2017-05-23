<?php class XmlTable extends XmlNotEmptyElement {

    public function getAllowedElements() {
        return '^((caption?)|(caption)?((col)*|(colgroup)*)|(caption)?((col)*|(colgroup)*)(thead)?|(caption)?((col)*|(colgroup)*)(thead)?(tfoot)?|(caption)?((col)*|(colgroup)*)(thead)?(tfoot)?((tbody)+|(tr)+)$';
    }

}

