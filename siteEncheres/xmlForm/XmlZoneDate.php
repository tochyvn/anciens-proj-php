<?php class XmlZoneDate extends XmlZoneTexte {

    public function __construct(array $t) {
        parent::__construct($t);
        $this->elements[1]->addAttribute("type", "date");
    }

}