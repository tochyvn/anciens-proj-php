<?php abstract  class XmlElement {
    protected $attributes = array();
    public function __construct(array $t = array()) {
        $this->attributes = $t;
    }

    public function getTagName() {
        return preg_replace('/Xml/', '', get_class($this));
    }

    abstract public function getAllowedElements();

    //un \351l\351ment de base est par d\351faut valid\351
    //les nouveaux composants devront r\351\351crire cette m\351thode selon leurs besoins
    public function valider() {
        return 0;
    }

    public function addAttribute($name, $value) {
        $this->attributes[$name] = $value;
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function setAttribute($name,$value) {
        $this->attributes[$name]=$value;
    }
    
    public function removeAttribute($name) {
        if (isset($this->attributes[$name]))
            unset($this->attributes[$name]);
    }
    
    abstract function toHTML();
}

