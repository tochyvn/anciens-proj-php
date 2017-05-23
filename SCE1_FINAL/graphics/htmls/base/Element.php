<?php
	/**
	* 
	*/

	abstract class Element extends Noeud
	{
            private $attributes;
		
            function __construct()
            {
                parent::__construct();
                $this->attributes=[];
            }
		
            public function getAttribute($key)
            {
		$value=null;
		if(isset($this->attributes[$key]))
		{
                    $value=$this->attributes[$key];
		}
		return $value;
            }
            public function getAttributes()
            {
		return $this->attributes;
            }
            public function setAttribute($key,$value)
            {
                if(isset($this->attributes[$key]))
		{
                    $this->removeAttribute($key);
                }
                $this->attributes[$key]=$value;
            }
            public function removeAttribute($key){
			
		if(isset($this->attributes[$key]))
		{
                    unset($this->attributes[$key]);
		}
            }
	}